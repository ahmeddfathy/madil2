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
            <div class="trend">
                <span>اليوم: {{ $stats['today_orders'] ?? 0 }}</span> |
                <span>الشهر: {{ $stats['month_orders'] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="icon-wrapper bg-success">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['revenue'] ?? 0, 2) }} ريال</div>
            <div class="stat-title">إجمالي الإيرادات</div>
            <div class="trend">
                <span>اليوم: {{ number_format($stats['today_revenue'] ?? 0, 2) }} ريال</span>
            </div>
        </div>
    </div>

    <!-- Users Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="icon-wrapper bg-info">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $stats['users'] }}</div>
            <div class="stat-title">إجمالي المستخدمين</div>
            <div class="trend">
                <span>المستخدمين النشطين</span>
            </div>
        </div>
    </div>

    <!-- Order Status Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="icon-wrapper bg-warning">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="stat-value">{{ $stats['pending_orders'] ?? 0 }}</div>
            <div class="stat-title">الطلبات المعلقة</div>
            <div class="trend">
                <span>قيد المعالجة: {{ $stats['processing_orders'] ?? 0 }}</span> |
                <span>مكتملة: {{ $stats['completed_orders'] ?? 0 }}</span>
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
                            <th>المنتجات</th>
                            <th>حالة الطلب</th>
                            <th>حالة الدفع</th>
                            <th>المبلغ</th>
                            <th>التاريخ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>{{ $order['id'] }}</td>
                            <td>{{ $order['user_name'] }}</td>
                            <td>
                                <div class="small">
                                    @foreach($order['items'] as $item)
                                        <div class="mb-1">
                                            {{ $item['product_name'] }}
                                            <span class="text-muted">
                                                ({{ $item['quantity'] }} × {{ number_format($item['unit_price'], 2) }} ريال = {{ number_format($item['total_price'], 2) }} ريال)
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order['status_color'] }}">
                                    {{ $order['status_text'] }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order['payment_status_color'] }}">
                                    {{ $order['payment_status_text'] }}
                                </span>
                            </td>
                            <td>{{ number_format($order['total'], 2) }} ريال</td>
                            <td>{{ $order['created_at'] }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order['id']) }}"
                                   class="btn btn-sm btn-primary"
                                   title="عرض تفاصيل الطلب">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-3">لا توجد طلبات حديثة</td>
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
    // تهيئة البيانات
    const chartConfig = {
        labels: JSON.parse('@json($chartLabels)'),
        data: JSON.parse('@json($chartData)'),
        orderStats: JSON.parse('@json($orderStats)')
    };

    // رسم البياني للمبيعات
    const salesChart = new Chart(
        document.getElementById('salesChart').getContext('2d'),
        {
            type: 'bar',
            data: {
                labels: chartConfig.labels,
                datasets: [{
                    label: 'المبيعات الشهرية (ريال)',
                    data: chartConfig.data,
                    backgroundColor: 'rgba(13, 110, 253, 0.2)',
                    borderColor: 'rgb(13, 110, 253)',
                    borderWidth: 2,
                    borderRadius: 5,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f0f0f0'
                        },
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('ar-SA', {
                                    style: 'currency',
                                    currency: 'SAR'
                                }).format(value);
                            },
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat('ar-SA', {
                                    style: 'currency',
                                    currency: 'SAR'
                                }).format(context.parsed.y);
                            }
                        }
                    }
                }
            }
        }
    );

    // رسم بياني لحالات الطلبات
    const orderStatusChart = new Chart(
        document.getElementById('orderStatusChart').getContext('2d'),
        {
            type: 'doughnut',
            data: {
                labels: ['مكتمل', 'قيد المعالجة', 'معلق', 'ملغي'],
                datasets: [{
                    data: [
                        chartConfig.orderStats.completed || 0,
                        chartConfig.orderStats.processing || 0,
                        chartConfig.orderStats.pending || 0,
                        chartConfig.orderStats.cancelled || 0
                    ],
                    backgroundColor: [
                        'rgba(25, 135, 84, 0.9)',
                        'rgba(13, 202, 240, 0.9)',
                        'rgba(255, 193, 7, 0.9)',
                        'rgba(220, 53, 69, 0.9)'
                    ],
                    borderColor: [
                        'rgb(25, 135, 84)',
                        'rgb(13, 202, 240)',
                        'rgb(255, 193, 7)',
                        'rgb(220, 53, 69)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 13
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${value} طلب (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        }
    );
</script>

@if(isset($error))
<script>
    // عرض رسالة الخطأ إذا وجدت
    Swal.fire({
        title: 'خطأ!',
        text: '{{ $error }}',
        icon: 'error',
        confirmButtonText: 'حسناً'
    });
</script>
@endif
@endsection
