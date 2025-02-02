<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Appointment;
use App\Models\CartItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->adminDashboard($request);
        }

        return $this->clientDashboard($user);
    }

    private function adminDashboard(Request $request)
    {
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
            'new_users' => User::where('created_at', '>=', $startDate)->count(),
            'new_orders' => Order::where('created_at', '>=', $startDate)->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
        ];

        // الطلبات الأخيرة
        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($order) {
                $order->status_color = $this->getStatusColor($order->order_status);
                $order->status_text = $this->getStatusText($order->order_status);
                return $order;
            });

        // إحصائيات حسب الفترة
        $periodStats = [
            'orders' => Order::where('created_at', '>=', $startDate)->count(),
            'revenue' => Order::where('created_at', '>=', $startDate)->sum('total_amount'),
            'users' => User::where('created_at', '>=', $startDate)->count(),
            'appointments' => Appointment::where('created_at', '>=', $startDate)->count(),
        ];

        // المواعيد القادمة
        $upcomingAppointments = Appointment::with('user')
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get()
            ->map(function($appointment) {
                $appointment->status_color = $this->getStatusColor($appointment->status);
                $appointment->status_text = $this->getStatusText($appointment->status);
                return $appointment;
            });

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'periodStats',
            'period',
            'upcomingAppointments'
        ));
    }

    private function clientDashboard($user)
    {
        // إحصائيات العميل
        $cartItemsCount = CartItem::join('carts', 'cart_items.cart_id', '=', 'carts.id')
            ->where('carts.user_id', $user->id)
            ->sum('cart_items.quantity');

        $stats = [
            'orders_count' => $user->orders()->count(),
            'appointments_count' => $user->appointments()->count(),
            'cart_items_count' => $cartItemsCount,
            'unread_notifications' => $user->unreadNotifications()->count(),
            'total_spent' => $user->orders()->sum('total_amount'),
            'completed_orders' => $user->orders()->where('order_status', 'completed')->count(),
        ];

        // الطلبات الأخيرة
        $recent_orders = $user->orders()
            ->with('items.product')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($order) {
                $order->status_color = $this->getStatusColor($order->order_status);
                $order->status_text = $this->getStatusText($order->order_status);
                return $order;
            });

        // المواعيد القادمة
        $upcoming_appointments = $user->appointments()
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(4)
            ->get()
            ->map(function($appointment) {
                $appointment->status_color = $this->getStatusColor($appointment->status);
                $appointment->status_text = $this->getStatusText($appointment->status);
                return $appointment;
            });

        // آخر الإشعارات
        $recent_notifications = $user->notifications()
            ->latest()
            ->take(5)
            ->get()
            ->map(function($notification) {
                $notification->icon = $this->getNotificationIcon($notification->type);
                return $notification;
            });

        // العناوين وأرقام الهواتف
        $addresses = $user->addresses()
            ->latest()
            ->get()
            ->map(function($address) {
                return [
                    'id' => $address->id,
                    'full_address' => $this->formatAddress($address),
                    'city' => $address->city,
                    'area' => $address->area,
                    'street' => $address->street,
                    'building_no' => $address->building_no,
                    'details' => $address->details,
                    'type' => $address->type,
                    'type_text' => $address->type_text,
                    'created_at' => $address->created_at->format('Y/m/d'),
                    'is_primary' => $address->is_primary,
                    'type_color' => $this->getAddressTypeColor($address->type)
                ];
            });

        $phones = $user->phoneNumbers()
            ->latest()
            ->get()
            ->map(function($phone) {
                return [
                    'id' => $phone->id,
                    'phone' => $this->formatPhoneNumber($phone->phone),
                    'type' => $phone->type,
                    'type_text' => $phone->type_text,
                    'created_at' => $phone->created_at->format('Y/m/d'),
                    'is_primary' => $phone->is_primary,
                    'type_color' => $this->getPhoneTypeColor($phone->type)
                ];
            });

        return view('dashboard', compact(
            'stats',
            'recent_orders',
            'upcoming_appointments',
            'recent_notifications',
            'addresses',
            'phones'
        ));
    }

    private function getStatusColor($status): string
    {
        return match($status) {
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            'confirmed' => 'success',
            default => 'secondary'
        };
    }

    private function getStatusText($status): string
    {
        return match($status) {
            'pending' => 'قيد الانتظار',
            'processing' => 'قيد المعالجة',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            'confirmed' => 'مؤكد',
            default => 'غير معروف'
        };
    }

    private function getNotificationIcon($type): string
    {
        return match($type) {
            'App\Notifications\OrderStatusChanged' => 'fa-shopping-bag',
            'App\Notifications\AppointmentConfirmed' => 'fa-calendar-check',
            'App\Notifications\AppointmentCancelled' => 'fa-calendar-times',
            'App\Notifications\NewOrder' => 'fa-shopping-cart',
            'App\Notifications\PaymentReceived' => 'fa-credit-card',
            default => 'fa-bell'
        };
    }

    private function formatPhoneNumber(string $phone): string
    {
        // تنسيق رقم الهاتف بشكل أفضل للقراءة
        return substr($phone, 0, 2) . ' ' . substr($phone, 2, 3) . ' ' . substr($phone, 5);
    }

    private function formatAddress(object $address): string
    {
        $parts = [
            $address->city,
            $address->area,
            'شارع ' . $address->street
        ];

        if ($address->building_no) {
            $parts[] = 'مبنى ' . $address->building_no;
        }

        if ($address->details) {
            $parts[] = $address->details;
        }

        return implode('، ', array_filter($parts));
    }

    private function getAddressTypeColor(string $type): string
    {
        return match($type) {
            'home' => 'success',
            'work' => 'info',
            'other' => 'secondary',
            default => 'primary'
        };
    }

    private function getPhoneTypeColor(string $type): string
    {
        return match($type) {
            'mobile' => 'success',
            'home' => 'info',
            'work' => 'warning',
            'other' => 'secondary',
            default => 'primary'
        };
    }
}
