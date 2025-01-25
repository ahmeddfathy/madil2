<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CheckoutException;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with(['items.product.images', 'items.product.category'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        \Log::info('Checkout process started', [
            'user_id' => Auth::id(),
            'is_authenticated' => Auth::check()
        ]);

        try {
            $validated = $request->validate([
                'shipping_address' => ['required', 'string', 'max:500', 'regex:/^[\p{L}\p{N}\s\-\,\.]+$/u'],
                'phone' => ['required', 'string', 'max:20', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
                'payment_method' => ['required', 'in:cash,card'],
                'notes' => ['nullable', 'string', 'max:1000', 'regex:/^[\p{L}\p{N}\s\-\,\.]+$/u'],
            ]);

            return DB::transaction(function () use ($request, $validated) {
                if (Auth::check()) {
                    $cart = Cart::where('user_id', Auth::id())
                        ->with(['items.product' => function ($query) {
                            $query->lockForUpdate();
                        }])
                        ->first();

                    if (!$cart || $cart->items->isEmpty()) {
                        throw new CheckoutException('Cart is empty');
                    }

                    foreach ($cart->items as $item) {
                        if ($item->product->stock < $item->quantity) {
                            throw new CheckoutException("Insufficient stock for {$item->product->name}");
                        }
                    }

                    $totalAmount = $cart->total_amount;

                    $order = Order::create([
                        'user_id' => Auth::id(),
                        'total_amount' => $totalAmount,
                        'shipping_address' => $validated['shipping_address'],
                        'phone' => $validated['phone'],
                        'payment_method' => $validated['payment_method'],
                        'payment_status' => $validated['payment_method'] === 'card' ?
                            Order::PAYMENT_STATUS_PENDING :
                            Order::PAYMENT_STATUS_PAID,
                        'order_status' => Order::ORDER_STATUS_PENDING,
                        'notes' => $validated['notes'] ?? null,
                    ]);

                    foreach ($cart->items as $item) {
                        $order->items()->create([
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'unit_price' => $item->product->price,
                            'subtotal' => $item->product->price * $item->quantity
                        ]);

                        $item->product->decrement('stock', $item->quantity);
                    }

                    if ($validated['payment_method'] === 'card') {
                        try {
                            $paymentResult = $this->processPayment($order);
                            if (!$paymentResult->success) {
                                throw new CheckoutException('Payment failed');
                            }
                        } catch (\Exception $e) {
                            throw new CheckoutException('Payment processing failed: ' . $e->getMessage());
                        }
                    }

                    $cart->items()->delete();
                    $cart->delete();

                    return redirect()->route('orders.show', $order)
                        ->with('success', 'Order placed successfully.');
                }
            });
        } catch (CheckoutException $e) {
            \Log::error('Checkout failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            \Log::error('Unexpected error during checkout', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }

    /**
     * معالجة عملية الدفع
     *
     * @param Order $order
     * @return object
     */
    protected function processPayment(Order $order)
    {
        // هنا يتم إضافة منطق معالجة الدفع
        // مثال: التكامل مع بوابة دفع
        return (object) ['success' => true];
    }
}
