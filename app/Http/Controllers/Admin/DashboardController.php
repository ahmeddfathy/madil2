<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // الإحصائيات الأساسية
            $stats = [
                'orders' => Order::count(),
                'users' => User::count(),
                'products' => Product::count(),
                'revenue' => Order::where('payment_status', Order::PAYMENT_STATUS_PAID)
                    ->sum('total_amount') ?? 0,
            ];

            // جلب بيانات المبيعات
            $salesData = Order::where('payment_status', Order::PAYMENT_STATUS_PAID)
                ->where('created_at', '>=', now()->subMonths(6))
                ->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('SUM(total_amount) as total'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // تجهيز بيانات الرسم البياني
            $chartLabels = [];
            $chartData = [];
            $monthlyGrowth = [];

            foreach ($salesData as $index => $data) {
                $chartLabels[] = Carbon::createFromFormat('Y-m', $data->month)->format('M Y');
                $chartData[] = round($data->total / 100, 2);

                if ($index > 0) {
                    $previousTotal = $salesData[$index - 1]->total;
                    $currentTotal = $data->total;
                    $growth = $previousTotal > 0
                        ? round((($currentTotal - $previousTotal) / $previousTotal) * 100, 1)
                        : 0;
                    $monthlyGrowth[] = $growth;
                } else {
                    $monthlyGrowth[] = 0;
                }
            }

            // إذا لم تكن هناك بيانات، نضيف قيم افتراضية
            if (empty($chartLabels)) {
                $chartLabels = [now()->format('M Y')];
                $chartData = [0];
                $monthlyGrowth = [0];
            }

            // أحدث الطلبات
            $recentOrders = Order::with('user')
                ->latest()
                ->take(5)
                ->get();

            // إحصائيات حالات الطلبات
            $orderStats = Order::select('order_status', DB::raw('count(*) as total'))
                ->whereNotNull('order_status')  // تأكد من أن الحالة غير فارغة
                ->groupBy('order_status')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->order_status => $item->total];
                })
                ->toArray();

            // إضافة الحالات الافتراضية إذا لم تكن موجودة
            $defaultStatuses = [
                Order::ORDER_STATUS_PENDING => 0,
                Order::ORDER_STATUS_PROCESSING => 0,
                Order::ORDER_STATUS_COMPLETED => 0,
                Order::ORDER_STATUS_CANCELLED => 0
            ];

            $orderStats = array_merge($defaultStatuses, $orderStats);

            // المنتجات الأكثر مبيعاً
            $topProducts = Product::withCount(['orderItems as sales_count' => function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('payment_status', Order::PAYMENT_STATUS_PAID);
                });
            }])
                ->orderByDesc('sales_count')
                ->take(5)
                ->get();

            return view('admin.dashboard', compact(
                'stats',
                'chartLabels',
                'chartData',
                'monthlyGrowth',
                'recentOrders',
                'orderStats',
                'topProducts'
            ));
        } catch (\Exception $e) {
            // في حالة حدوث خطأ، نعيد القيم الافتراضية
            return view('admin.dashboard', [
                'stats' => [
                    'orders' => 0,
                    'users' => 0,
                    'products' => 0,
                    'revenue' => 0
                ],
                'chartLabels' => [now()->format('M Y')],
                'chartData' => [0],
                'monthlyGrowth' => [0],
                'recentOrders' => collect([]),
                'orderStats' => $defaultStatuses
            ])->withErrors('Error loading dashboard data: ' . $e->getMessage());
        }
    }
}
