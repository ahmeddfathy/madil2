@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('page_title', 'لوحة التحكم')

@section('content')
<!-- Stats Grid -->
<div class="row g-3 mb-4">
    <!-- Orders Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="icon-wrapper bg-primary">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-value">{{ $stats['orders'] ?? 0 }}</div>
            <div class="stat-title">إجمالي الطلبات</div>
            @if(!empty($monthlyGrowth))
            <div class="trend {{ $monthlyGrowth[0] >= 0 ? 'up' : 'down' }}">
                <i class="fas fa-arrow-{{ $monthlyGrowth[0] >= 0 ? 'up' : 'down' }}"></i>
                <span>{{ abs($monthlyGrowth[0]) }}% {{ $monthlyGrowth[0] >= 0 ? 'زيادة' : 'نقص' }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Users Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="icon-wrapper bg-info">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $stats['users'] ?? 0 }}</div>
            <div class="stat-title">إجمالي المستخدمين</div>
            <div class="trend up">
                <i class="fas fa-arrow-up"></i>
                <span>المستخدمين النشطين</span>
            </div>
        </div>
    </div>

    <!-- Products Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="icon-wrapper bg-success">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-value">{{ $stats['products'] ?? 0 }}</div>
            <div class="stat-title">إجمالي المنتجات</div>
            <div class="trend up">
                <i class="fas fa-arrow-up"></i>
                <span>متوفر في المخزون</span>
            </div>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="icon-wrapper bg-warning">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-value">{{ number_format(($stats['revenue'] ?? 0) / 100, 2) }}</div>
            <div class="stat-title">إجمالي الإيرادات (ريال)</div>
            <div class="trend up">
                <i class="fas fa-arrow-up"></i>
                <span>إجمالي المبيعات</span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-3 mb-4">
    @can('create', App\Models\Product::class)
    <div class="col-12 col-md-4">
        <a href="{{ route('admin.products.create') }}" class="action-card d-block h-100">
            <div class="action-icon bg-primary">
                <i class="fas fa-plus"></i>
            </div>
            <h5>إضافة منتج</h5>
            <p class="mb-0">إضافة منتجات جديدة للمتجر</p>
        </a>
    </div>
    @endcan

    @can('viewAny', App\Models\Order::class)
    <div class="col-12 col-md-4">
        <a href="{{ route('admin.orders.index') }}" class="action-card d-block h-100">
            <div class="action-icon bg-info">
                <i class="fas fa-tasks"></i>
            </div>
            <h5>إدارة الطلبات</h5>
            <p class="mb-0">عرض وإدارة طلبات العملاء</p>
        </a>
    </div>
    @endcan

    @can('viewAny', App\Models\Appointment::class)
    <div class="col-12 col-md-4">
        <a href="{{ route('admin.appointments.index') }}" class="action-card d-block h-100">
            <div class="action-icon bg-success">
                <i class="fas fa-calendar"></i>
            </div>
            <h5>المواعيد</h5>
            <p class="mb-0">إدارة مواعيد العملاء</p>
        </a>
    </div>
    @endcan
</div>

<!-- Charts & Tables -->
<div class="row g-4">
    <!-- Sales Chart -->
    <div class="col-12 col-lg-8">
        <div class="chart-container">
            <div class="activity-header border-bottom">
                <h5 class="activity-title">نظرة عامة على المبيعات</h5>
            </div>
            <div class="chart-wrapper">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Order Status Chart -->
    <div class="col-12 col-lg-4">
        <div class="chart-container">
            <div class="activity-header border-bottom">
                <h5 class="activity-title">توزيع حالات الطلبات</h5>
            </div>
            <div class="chart-wrapper">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="activity-section bg-white rounded-3 shadow-sm">
            <div class="activity-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="activity-title mb-0">آخر الطلبات</h5>
                @can('viewAny', App\Models\Order::class)
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">عرض الكل</a>
                @endcan
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>الطلب</th>
                            <th>العميل</th>
                            <th>الحالة</th>
                            <th>المبلغ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status_color }}">
                                    {{ $order->status_text }}
                                </span>
                            </td>
                            <td>{{ number_format($order->total / 100, 2) }} ريال</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-3">لا توجد طلبات حديثة</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
            datasets: [{
                label: 'المبيعات',
                data: [12, 19, 3, 5, 2, 3],
                borderColor: '#0d6efd',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Order Status Chart
    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['مكتمل', 'قيد المعالجة', 'ملغي'],
            datasets: [{
                data: [12, 19, 3],
                backgroundColor: ['#198754', '#0dcaf0', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endsection
