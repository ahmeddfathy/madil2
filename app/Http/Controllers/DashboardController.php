<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            // تحديد الفترة (أسبوع/شهر/سنة)
            $period = $request->get('period', 'week');

            // تحديد تاريخ البداية حسب الفترة المختارة
            $startDate = match ($period) {
                'week' => Carbon::now()->subWeek(),
                'month' => Carbon::now()->subMonth(),
                'year' => Carbon::now()->subYear(),
                default => Carbon::now()->subWeek(),
            };

            // إحصائيات عامة
            $stats = [
                'users' => User::count(),
                'products' => Product::count(),
                'orders' => Order::count(),
                'revenue' => Order::sum('total_amount'),
            ];

            // الطلبات الأخيرة
            $recentOrders = Order::with('user')
                ->latest()
                ->take(5)
                ->get();

            // إحصائيات حسب الفترة
            $periodStats = [
                'orders' => Order::where('created_at', '>=', $startDate)->count(),
                'revenue' => Order::where('created_at', '>=', $startDate)->sum('total_amount'),
                'users' => User::where('created_at', '>=', $startDate)->count(),
            ];

            return view('admin.dashboard', compact(
                'stats',
                'recentOrders',
                'periodStats',
                'period'
            ));
        }

        // للمستخدم العادي
        $orders = auth()->user()->orders()->latest()->take(5)->get();
        return view('dashboard', compact('orders'));
    }
}
