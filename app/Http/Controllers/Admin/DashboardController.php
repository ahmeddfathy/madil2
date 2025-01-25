<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    $totalOrders = Order::count();
    $totalRevenue = Order::where('status', '!=', Order::STATUS_CANCELLED)
      ->sum('total_amount');
    $totalProducts = Product::count();
    $lowStockProducts = Product::where('stock', '<', 5)->count();

    $recentOrders = Order::with('user')
      ->latest()
      ->take(5)
      ->get();

    return view('admin.dashboard', compact(
      'totalOrders',
      'totalRevenue',
      'totalProducts',
      'lowStockProducts',
      'recentOrders'
    ));
  }

  protected function getStartDate(string $period): Carbon
  {
    return match ($period) {
      'week' => Carbon::now()->subWeek(),
      'month' => Carbon::now()->startOfMonth(),
      'year' => Carbon::now()->startOfYear(),
      default => Carbon::now()->startOfMonth(),
    };
  }

  protected function getSalesStatistics(Carbon $startDate): array
  {
    $totalSales = Order::where('created_at', '>=', $startDate)
      ->where('status', '!=', Order::STATUS_CANCELLED)
      ->sum('total_amount');

    $orderCount = Order::where('created_at', '>=', $startDate)
      ->where('status', '!=', Order::STATUS_CANCELLED)
      ->count();

    $dailySales = Order::where('created_at', '>=', $startDate)
      ->where('status', '!=', Order::STATUS_CANCELLED)
      ->select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(total_amount) as total')
      )
      ->groupBy('date')
      ->get()
      ->pluck('total', 'date')
      ->toArray();

    return [
      'total_sales' => $totalSales,
      'order_count' => $orderCount,
      'daily_sales' => $dailySales,
    ];
  }

  protected function getTopProducts(Carbon $startDate): object
  {
    return OrderItem::select(
      'product_id',
      DB::raw('SUM(quantity) as total_quantity'),
      DB::raw('SUM(subtotal) as total_sales')
    )
      ->with('product')
      ->whereHas('order', function ($query) use ($startDate) {
        $query->where('created_at', '>=', $startDate)
          ->where('status', '!=', Order::STATUS_CANCELLED);
      })
      ->groupBy('product_id')
      ->orderByDesc('total_quantity')
      ->take(5)
      ->get();
  }
}
