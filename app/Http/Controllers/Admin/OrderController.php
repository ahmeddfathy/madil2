<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
  public function index(Request $request)
  {
    try {
        $query = Order::with(['user', 'items.product'])
            ->latest();

        // Filter by order number
        if ($request->order_number) {
            $query->where('order_number', 'like', "%{$request->order_number}%");
        }

        // Filter by status
        if ($request->order_status) {
            $query->where('order_status', $request->order_status);
        }

        // Filter by payment status
        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by customer name, email or order number
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', "%{$request->search}%")
                  ->orWhereHas('user', function ($userQuery) use ($request) {
                      $userQuery->where('name', 'like', "%{$request->search}%")
                               ->orWhere('email', 'like', "%{$request->search}%");
                  });
            });
        }

        // Get statistics
        $stats = [
            'total_orders' => Order::count(),
            'completed_orders' => Order::where('order_status', Order::ORDER_STATUS_COMPLETED)->count(),
            'processing_orders' => Order::where('order_status', Order::ORDER_STATUS_PROCESSING)->count(),
            'total_revenue' => Order::where('payment_status', Order::PAYMENT_STATUS_PAID)->sum('total_amount')
        ];

        $orders = $query->paginate(10);

        // Transform orders data
        $transformedCollection = collect($orders->items())->map(function ($order) {
            return [
                'id' => $order->id,
                'uuid' => $order->uuid,
                'order_number' => $order->order_number,
                'customer_name' => $order->user->name,
                'customer_phone' => $order->user->phone ?? '-',
                'items_count' => $order->items->count(),
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                        'total' => $item->quantity * $item->product->price
                    ];
                }),
                'original_amount' => $order->original_amount,
                'quantity_discount' => $order->quantity_discount,
                'coupon_discount' => $order->coupon_discount,
                'total' => $order->total_amount,
                'status' => $order->order_status,
                'status_text' => match($order->order_status) {
                    Order::ORDER_STATUS_COMPLETED => 'مكتمل',
                    Order::ORDER_STATUS_PROCESSING => 'قيد المعالجة',
                    Order::ORDER_STATUS_PENDING => 'معلق',
                    Order::ORDER_STATUS_CANCELLED => 'ملغي',
                    Order::ORDER_STATUS_OUT_FOR_DELIVERY => 'جاري التوصيل',
                    Order::ORDER_STATUS_ON_THE_WAY => 'في الطريق',
                    Order::ORDER_STATUS_DELIVERED => 'تم التوصيل',
                    Order::ORDER_STATUS_RETURNED => 'مرتجع',
                    default => 'غير معروف'
                },
                'status_color' => match($order->order_status) {
                    Order::ORDER_STATUS_COMPLETED => 'success',
                    Order::ORDER_STATUS_PROCESSING => 'info',
                    Order::ORDER_STATUS_PENDING => 'warning',
                    Order::ORDER_STATUS_CANCELLED => 'danger',
                    Order::ORDER_STATUS_OUT_FOR_DELIVERY => 'primary',
                    Order::ORDER_STATUS_ON_THE_WAY => 'info',
                    Order::ORDER_STATUS_DELIVERED => 'success',
                    Order::ORDER_STATUS_RETURNED => 'danger',
                    default => 'secondary'
                },
                'payment_status' => $order->payment_status,
                'payment_status_text' => match($order->payment_status) {
                    Order::PAYMENT_STATUS_PAID => 'مدفوع',
                    Order::PAYMENT_STATUS_PENDING => 'معلق',
                    Order::PAYMENT_STATUS_FAILED => 'فشل',
                    default => 'غير معروف'
                },
                'payment_status_color' => match($order->payment_status) {
                    Order::PAYMENT_STATUS_PAID => 'success',
                    Order::PAYMENT_STATUS_PENDING => 'warning',
                    Order::PAYMENT_STATUS_FAILED => 'danger',
                    default => 'secondary'
                },
                'created_at' => $order->created_at->format('Y-m-d H:i'),
                'created_at_formatted' => $order->created_at->format('Y/m/d')
            ];
        });

        // Create a new paginator instance with the transformed data
        $orders = new \Illuminate\Pagination\LengthAwarePaginator(
            $transformedCollection,
            $orders->total(),
            $orders->perPage(),
            $orders->currentPage(),
            ['path' => \Illuminate\Support\Facades\Request::url(), 'query' => \Illuminate\Support\Facades\Request::query()]
        );

        // Get available statuses for filtering
        $orderStatuses = [
            Order::ORDER_STATUS_PENDING => 'قيد الانتظار',
            Order::ORDER_STATUS_PROCESSING => 'قيد المعالجة',
            Order::ORDER_STATUS_OUT_FOR_DELIVERY => 'جاري التوصيل',
            Order::ORDER_STATUS_ON_THE_WAY => 'في الطريق',
            Order::ORDER_STATUS_DELIVERED => 'تم التوصيل',
            Order::ORDER_STATUS_COMPLETED => 'مكتمل',
            Order::ORDER_STATUS_RETURNED => 'مرتجع',
            Order::ORDER_STATUS_CANCELLED => 'ملغي'
        ];

        $paymentStatuses = [
            Order::PAYMENT_STATUS_PENDING => 'معلق',
            Order::PAYMENT_STATUS_PAID => 'مدفوع',
            Order::PAYMENT_STATUS_FAILED => 'فشل'
        ];

        return view('admin.orders.index', compact('orders', 'orderStatuses', 'paymentStatuses', 'stats'));
    } catch (\Exception $e) {
        Log::error('Error in orders index: ' . $e->getMessage());
        return back()->with('error', 'حدث خطأ أثناء تحميل الطلبات');
    }
  }

  public function show($uuid)
  {
    $order = Order::where('uuid', $uuid)
        ->with(['user', 'items.product', 'items.product.category', 'address', 'phoneNumber'])
        ->firstOrFail();

    // Format order for display
    $formattedOrder = $this->formatOrderForDisplay($order);

    // Get additional addresses and phone numbers for the user if available
    $additionalAddresses = collect([]);
    $additionalPhones = collect([]);

    if ($order->user) {
        // Get all addresses for the user
        $additionalAddresses = $order->user->addresses;

        // Get all phone numbers for the user
        $additionalPhones = $order->user->phoneNumbers;
    }

    return view('admin.orders.show', [
        'order' => $order,
        'formattedOrder' => $formattedOrder,
        'additionalAddresses' => $additionalAddresses,
        'additionalPhones' => $additionalPhones,
    ]);
  }

  public function updateStatus(Request $request, Order $order)
  {
    try {
        $validated = $request->validate([
            'order_status' => ['required', 'string', 'in:' . implode(',', [
                Order::ORDER_STATUS_PENDING,
                Order::ORDER_STATUS_PROCESSING,
                Order::ORDER_STATUS_COMPLETED,
                Order::ORDER_STATUS_CANCELLED,
                Order::ORDER_STATUS_OUT_FOR_DELIVERY,
                Order::ORDER_STATUS_ON_THE_WAY,
                Order::ORDER_STATUS_DELIVERED,
                Order::ORDER_STATUS_RETURNED,
            ])],
        ]);

        DB::beginTransaction();

        $oldStatus = $order->order_status;
        $newStatus = $validated['order_status'];

        // تحديث المخزون عند اكتمال الطلب أو التوصيل
        if (($newStatus === Order::ORDER_STATUS_COMPLETED || $newStatus === Order::ORDER_STATUS_DELIVERED)
            && !in_array($oldStatus, [Order::ORDER_STATUS_COMPLETED, Order::ORDER_STATUS_DELIVERED])) {
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product->stock < $item->quantity) {
                    DB::rollBack();
                    return back()->with('error', "المخزون غير كافي للمنتج: {$product->name}");
                }
                $product->decrement('stock', $item->quantity);
            }
        }

        // إعادة المخزون عند تغيير حالة الطلب من مكتمل/تم التوصيل إلى أي حالة أخرى
        if (in_array($oldStatus, [Order::ORDER_STATUS_COMPLETED, Order::ORDER_STATUS_DELIVERED])
            && !in_array($newStatus, [Order::ORDER_STATUS_COMPLETED, Order::ORDER_STATUS_DELIVERED])) {
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        $order->update([
            'order_status' => $validated['order_status']
        ]);

        DB::commit();

        if ($order->user) {
            $order->user->notify(new OrderStatusUpdated($order));
        }

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error updating order status', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return back()->with('error', 'فشل تحديث حالة الطلب: ' . $e->getMessage());
    }
  }

  private function formatOrderForDisplay(Order $order)
  {
    return [
        'id' => $order->id,
        'uuid' => $order->uuid,
        'order_number' => $order->order_number,
        'customer' => [
            'name' => $order->user->name ?? 'العميل غير متوفر',
            'email' => $order->user->email ?? '-',
            'phone' => $order->user->phone ?? '-',
        ],
        'address' => $order->shipping_address ?? ($order->address ? $order->address->getFullAddressAttribute() : '-'),
        'phone' => $order->phone ?? ($order->phoneNumber ? $order->phoneNumber->phone : '-'),
        'items' => $order->items->map(function ($item) {
            return [
                'product_name' => $item->product->name ?? 'المنتج غير متوفر',
                'product_code' => $item->product->code ?? '-',
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->price * $item->quantity,
            ];
        }),
        'original_amount' => $order->original_amount,
        'quantity_discount' => $order->quantity_discount,
        'coupon_discount' => $order->coupon_discount,
        'total_amount' => $order->total_amount,
        'status' => [
            'code' => $order->order_status,
            'text' => match($order->order_status) {
                Order::ORDER_STATUS_COMPLETED => 'مكتمل',
                Order::ORDER_STATUS_PROCESSING => 'قيد المعالجة',
                Order::ORDER_STATUS_PENDING => 'معلق',
                Order::ORDER_STATUS_CANCELLED => 'ملغي',
                Order::ORDER_STATUS_OUT_FOR_DELIVERY => 'جاري التوصيل',
                Order::ORDER_STATUS_ON_THE_WAY => 'في الطريق',
                Order::ORDER_STATUS_DELIVERED => 'تم التوصيل',
                Order::ORDER_STATUS_RETURNED => 'مرتجع',
                default => 'غير معروف'
            }
        ],
        'payment' => [
            'status' => $order->payment_status,
            'text' => match($order->payment_status) {
                Order::PAYMENT_STATUS_PAID => 'مدفوع',
                Order::PAYMENT_STATUS_PENDING => 'معلق',
                Order::PAYMENT_STATUS_FAILED => 'فشل',
                default => 'غير معروف'
            }
        ],
        'created_at' => $order->created_at->format('Y-m-d H:i'),
        'formatted_date' => $order->created_at->format('d/m/Y'),
        'notes' => $order->notes ?? '-'
    ];
  }

  public function updatePaymentStatus(Request $request, Order $order)
  {
    $validated = $request->validate([
      'payment_status' => ['required', 'string', 'in:' . implode(',', [
        Order::PAYMENT_STATUS_PENDING,
        Order::PAYMENT_STATUS_PAID,
        Order::PAYMENT_STATUS_FAILED,
      ])],
    ]);

    $order->update([
      'payment_status' => $validated['payment_status']
    ]);

    return back()->with('success', 'Payment status updated successfully.');
  }
}
