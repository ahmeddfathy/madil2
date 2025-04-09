<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Coupon;
use App\Services\DiscountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CheckoutException;
use App\Notifications\OrderCreated;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
  protected $discountService;

  public function __construct(DiscountService $discountService)
  {
    $this->discountService = $discountService;
  }

  public function index()
  {
    if (!Auth::check()) {
      return redirect()->route('login')
        ->with('error', 'يجب تسجيل الدخول لإتمام عملية الشراء');
    }

    $cart = Cart::with(['items.product'])
      ->where('user_id', Auth::id())
      ->first();

    if (!$cart || $cart->items->isEmpty()) {
      return redirect()->route('products.index')
        ->with('error', 'السلة فارغة');
    }

    // الحصول على كود الكوبون من الجلسة
    $couponCode = session('coupon_code');

    // تطبيق الخصومات وحساب القيمة النهائية
    $discountResult = $this->applyDiscounts($cart, $couponCode);

    // إعادة حساب خصومات الكمية في الوقت الفعلي للعرض
    $quantityDiscounts = [];
    $quantityDiscountsTotal = 0;

    foreach ($cart->items as $item) {
      $quantityDiscount = $this->discountService->getQuantityDiscount($item->product, $item->quantity);
      if ($quantityDiscount) {
        $discountAmount = $quantityDiscount->calculateDiscount($item->unit_price, $item->quantity);
        $quantityDiscounts[] = [
          'product_id' => $item->product_id,
          'product_name' => $item->product->name,
          'discount_amount' => $discountAmount,
          'quantity' => $item->quantity,
          'discount_type' => $quantityDiscount->type,
          'discount_value' => $quantityDiscount->value
        ];
        $quantityDiscountsTotal += $discountAmount;
      }
    }

    // التحقق من صلاحية الكوبون في الوقت الفعلي
    $couponData = null;
    if ($couponCode && isset($discountResult['coupon_applied']) && $discountResult['coupon_applied']) {
      $couponData = [
        'code' => $couponCode,
        'name' => $discountResult['coupon_name'],
        'discount_amount' => $discountResult['coupon_discount'],
        'is_partial' => isset($discountResult['partial_discount']) && $discountResult['partial_discount'],
        'valid_product_ids' => isset($discountResult['valid_items'])
          ? collect($discountResult['valid_items'])->pluck('product_id')->toArray()
          : [],
        'partial_discount_message' => isset($discountResult['partial_discount']) && $discountResult['partial_discount']
          ? "تم تطبيق الخصم على المنتجات التالية فقط: " . collect($discountResult['valid_items'])->pluck('name')->implode('، ')
          : null
      ];
    }

    return view('checkout.index', compact(
      'cart',
      'quantityDiscounts',
      'quantityDiscountsTotal',
      'couponData'
    ));
  }

  /**
   * Apply a coupon code via AJAX
   */
  public function applyCoupon(Request $request)
  {
    $request->validate([
      'coupon_code' => 'required|string|max:50'
    ]);

    $couponCode = $request->input('coupon_code');

    if (!Auth::check()) {
      return response()->json([
        'success' => false,
        'message' => 'يجب تسجيل الدخول لتطبيق كود الخصم'
      ]);
    }

    $cart = Cart::with(['items.product'])
      ->where('user_id', Auth::id())
      ->first();

    if (!$cart || $cart->items->isEmpty()) {
      return response()->json([
        'success' => false,
        'message' => 'السلة فارغة'
      ]);
    }

    $result = $this->applyDiscounts($cart, $couponCode);

    if ($result['coupon_applied']) {
      $response = [
        'success' => true,
        'message' => 'تم تطبيق كود الخصم بنجاح',
        'discount_amount' => number_format($result['coupon_discount'], 2),
        'final_amount' => number_format($result['final_amount'], 2)
      ];

      // إضافة معلومات الخصم الجزئي إذا كان ينطبق على منتجات محددة فقط
      if (session()->has('partial_discount') && session('partial_discount')) {
        $response['partial_discount'] = true;
        $response['partial_discount_message'] = session('partial_discount_message');
        $response['valid_product_ids'] = session('valid_product_ids');
      }

      return response()->json($response);
    } else {
      return response()->json([
        'success' => false,
        'message' => $result['messages'][count($result['messages']) - 1] ?? 'فشل تطبيق كود الخصم'
      ]);
    }
  }

  /**
   * Apply both bulk discounts and coupon discounts
   */
  private function applyDiscounts($cart, $couponCode = null)
  {
    $result = $this->discountService->calculateFinalAmount($cart, $couponCode);

    // تطبيق خصم الكمية
    $quantityDiscounts = [];
    foreach ($cart->items as $item) {
      $quantityDiscount = $this->discountService->getQuantityDiscount($item->product, $item->quantity);
      if ($quantityDiscount) {
        $discountAmount = $quantityDiscount->calculateDiscount($item->unit_price, $item->quantity);
        $quantityDiscounts[] = [
          'product_id' => $item->product_id,
          'product_name' => $item->product->name,
          'discount_amount' => $discountAmount,
          'quantity' => $item->quantity,
          'discount_type' => $quantityDiscount->type,
          'discount_value' => $quantityDiscount->value
        ];
        $result['final_amount'] -= $discountAmount;
      }
    }

    // Store discount information in session
    if ($result['coupon_applied']) {
      $sessionData = [
        'coupon_code' => $couponCode,
        'coupon_applied' => true,
        'coupon_name' => $result['coupon_name'],
        'coupon_discount_amount' => number_format($result['coupon_discount'], 2),
      ];

      // إذا كان الخصم جزئي (على منتجات محددة فقط)
      if (isset($result['partial_discount']) && $result['partial_discount']) {
        $sessionData['partial_discount'] = true;
        $sessionData['valid_product_ids'] = collect($result['valid_items'])->pluck('product_id')->toArray();

        // إضافة رسالة توضيحية للمستخدم
        $validProductNames = collect($result['valid_items'])->pluck('name')->implode('، ');
        $sessionData['partial_discount_message'] = "تم تطبيق الخصم على المنتجات التالية فقط: " . $validProductNames;
      }

      session($sessionData);
    } else if (isset($result['messages']) && !empty($result['messages'])) {
      // If coupon wasn't applied but we have an error message, remove any existing coupon
      session()->forget(['coupon_code', 'coupon_applied', 'coupon_name', 'coupon_discount_amount', 'partial_discount', 'valid_product_ids', 'partial_discount_message']);
    }

    // تخزين معلومات خصم الكمية في الجلسة
    if (!empty($quantityDiscounts)) {
      session([
        'quantity_discounts' => $quantityDiscounts,
        'quantity_discounts_total' => collect($quantityDiscounts)->sum('discount_amount')
      ]);
    }

    session(['final_amount' => $result['final_amount']]);

    return $result;
  }

  public function store(Request $request)
  {
    try {
      if (!Auth::check()) {
        throw new CheckoutException('يجب تسجيل الدخول لإتمام عملية الشراء');
      }

      $cart = Cart::where('user_id', Auth::id())
        ->with(['items.product'])
        ->first();

      if (!$cart || $cart->items->isEmpty()) {
        throw new CheckoutException('السلة فارغة');
      }

      $validated = $request->validate([
        'shipping_address' => ['required', 'string', 'max:500'],
        'phone' => ['required', 'string', 'max:20', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
        'notes' => ['nullable', 'string', 'max:1000'],
        'payment_method' => ['required', 'in:cash'],
        'coupon_code' => ['nullable', 'string', 'max:50'],
        'policy_agreement' => ['required', 'accepted']
      ]);

      return DB::transaction(function () use ($request, $validated, $cart) {
        // Check stock for all items
        foreach ($cart->items as $item) {
          if ($item->product->stock < $item->quantity) {
            throw new CheckoutException("الكمية المطلوبة غير متوفرة من {$item->product->name}");
          }
        }

        // Get original and final amounts
        $totalAmount = $cart->total_amount;
        $finalAmount = session('final_amount', $totalAmount);
        $couponCode = session('coupon_code') ?? $request->input('coupon_code');

        // Apply discounts if not already applied
        if ($couponCode && !session('coupon_applied')) {
          $discountResult = $this->applyDiscounts($cart, $couponCode);
          $finalAmount = $discountResult['final_amount'];
        }

        // Calculate discounts
        $couponDiscount = session('coupon_applied') ?
          (float) str_replace(',', '', session('coupon_discount_amount')) : 0;

        $orderData = [
          'user_id' => Auth::id(),
          'total_amount' => $finalAmount,
          'original_amount' => $totalAmount,
          'coupon_discount' => $couponDiscount,
          'coupon_code' => session('coupon_code'),
          'shipping_address' => $validated['shipping_address'],
          'phone' => $validated['phone'],
          'payment_method' => $validated['payment_method'],
          'payment_status' => Order::PAYMENT_STATUS_PENDING,
          'order_status' => Order::ORDER_STATUS_PENDING,
          'notes' => $validated['notes'] ?? null,
          'policy_agreement' => true,
          'amount_paid' => 0
        ];

        $order = Order::create($orderData);

        // Create order items
        foreach ($cart->items as $item) {
          $orderItemData = [
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'unit_price' => $item->unit_price,
            'subtotal' => $item->subtotal,
            'color' => $item->color,
            'size' => $item->size
          ];

          $order->items()->create($orderItemData);
        }

        // If coupon was applied, increment the usage count
        if (session('coupon_applied') && session('coupon_code')) {
          $coupon = Coupon::where('code', session('coupon_code'))->first();
          if ($coupon) {
            $coupon->incrementUsage();

            // تسجيل استخدام الكوبون من قبل المستخدم
            $coupon->markAsUsedByUser(Auth::id(), $order->id);
          }
        }

        $cart->items()->delete();
        $cart->delete();

        // Clear discount session data
        session()->forget([
          'coupon_code',
          'coupon_applied',
          'coupon_name',
          'coupon_discount_amount',
          'final_amount'
        ]);

        // Send order confirmation notification
        try {
          $order->user->notify(new OrderCreated($order));
        } catch (\Exception $e) {
          // Silently continue if notification fails
        }

        return redirect()->route('orders.show', $order)
          ->with('success', 'تم إنشاء الطلب بنجاح');
      });
    } catch (ValidationException $e) {
      return back()->withErrors($e->errors())->withInput();
    } catch (CheckoutException $e) {
      return back()
        ->withInput()
        ->withErrors(['error' => $e->getMessage()]);
    } catch (\Exception $e) {
      return back()
        ->withInput()
        ->withErrors(['error' => 'حدث خطأ غير متوقع. الرجاء المحاولة مرة أخرى أو الاتصال بالدعم الفني.']);
    }
  }
}
