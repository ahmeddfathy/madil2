<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
  public function index(Request $request)
  {
    $query = Order::with(['user', 'items.product'])
      ->latest();

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

    // Search by customer name or email
    if ($request->search) {
      $query->whereHas('user', function ($q) use ($request) {
        $q->where('name', 'like', "%{$request->search}%")
          ->orWhere('email', 'like', "%{$request->search}%");
      });
    }

    $orders = $query->paginate(10)
      ->withQueryString();

    // Get available statuses for filtering
    $orderStatuses = [
      Order::ORDER_STATUS_PENDING => 'Pending',
      Order::ORDER_STATUS_PROCESSING => 'Processing',
      Order::ORDER_STATUS_COMPLETED => 'Completed',
      Order::ORDER_STATUS_CANCELLED => 'Cancelled'
    ];

    $paymentStatuses = [
      Order::PAYMENT_STATUS_PENDING => 'Pending',
      Order::PAYMENT_STATUS_PAID => 'Paid',
      Order::PAYMENT_STATUS_FAILED => 'Failed'
    ];

    return view('admin.orders.index', compact('orders', 'orderStatuses', 'paymentStatuses'));
  }

  public function show(Order $order)
  {
    $order->load(['user', 'items.product']);
    return view('admin.orders.show', compact('order'));
  }

  public function updateStatus(Request $request, Order $order)
  {
    \Log::info('Updating order status - Start', [
        'order_id' => $order->id,
        'current_status' => $order->order_status,
        'new_status' => $request->order_status,
        'request_data' => $request->all(),
        'order_data' => $order->toArray()
    ]);

    try {
        $validated = $request->validate([
            'order_status' => ['required', 'string', 'in:' . implode(',', [
                Order::ORDER_STATUS_PENDING,
                Order::ORDER_STATUS_PROCESSING,
                Order::ORDER_STATUS_COMPLETED,
                Order::ORDER_STATUS_CANCELLED,
            ])],
        ]);

        DB::beginTransaction();

        $updated = $order->update([
            'order_status' => $validated['order_status']
        ]);

        \Log::info('Update operation result', [
            'updated' => $updated,
            'new_order_data' => $order->fresh()->toArray()
        ]);

        DB::commit();

        // Notify the customer about the status change
        if ($order->user) {
            $order->user->notify(new OrderStatusUpdated($order));
        }

        return back()->with('success', 'Order status updated successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Error updating order status', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return back()->with('error', 'Failed to update order status: ' . $e->getMessage());
    }
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
