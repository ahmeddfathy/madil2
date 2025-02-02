<x-app-layout>
    <!-- تضمين ملفات CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/admin-dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('لوحة التحكم') }}
        </h2>
    </x-slot>

    <div class="admin-layout">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <div class="sidebar shadow-sm" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    مدير مديل
                </div>
            </div>

            <div class="sidebar-nav">
                <!-- Dashboard Section -->
                <div class="nav-section">
                    <div class="nav-section-title">الرئيسية</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span class="nav-title">لوحة التحكم</span>
                        </a>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="nav-section">
                    <div class="nav-section-title">المنتجات</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="fas fa-box"></i>
                            <span class="nav-title">المنتجات</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i>
                            <span class="nav-title">التصنيفات</span>
                        </a>
                    </div>
                </div>

                <!-- Orders Section -->
                <div class="nav-section">
                    <div class="nav-section-title">الطلبات</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="nav-title">الطلبات</span>
                        </a>
                    </div>
                </div>

                <!-- Appointments Section -->
                <div class="nav-section">
                    <div class="nav-section-title">المواعيد</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.appointments.index') }}" class="nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar"></i>
                            <span class="nav-title">المواعيد</span>
                        </a>
                    </div>
                </div>

                <!-- Reports Section -->
                <div class="nav-section">
                    <div class="nav-section-title">التقارير</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar"></i>
                            <span class="nav-title">التقارير</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Toggle Button -->
        <button class="sidebar-toggle d-lg-none" id="sidebarToggle" aria-label="Toggle Sidebar">
            <i class="fas fa-chevron-left"></i>
        </button>

        <!-- Main Content -->
        <div class="main-content-wrapper">
            <div class="dashboard-wrapper container-fluid px-3 px-md-4">
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
                <div class="row g-4">
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
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->user->name ?? 'غير محدد' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->order_status == 'completed' ? 'success' : ($order->order_status == 'pending' ? 'warning' : ($order->order_status == 'cancelled' ? 'danger' : 'info')) }}">
                                                    @switch($order->order_status)
                                                        @case('pending')
                                                            قيد الانتظار
                                                            @break
                                                        @case('processing')
                                                            قيد المعالجة
                                                            @break
                                                        @case('completed')
                                                            مكتمل
                                                            @break
                                                        @case('cancelled')
                                                            ملغي
                                                            @break
                                                        @default
                                                            {{ $order->order_status }}
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td>{{ number_format($order->total_amount / 100, 2) }} ريال</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">لا توجد طلبات</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- تضمين Bootstrap و Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // تهيئة المتغيرات
        const chartLabels = @json($chartLabels ?? []);
        const chartData = @json($chartData ?? []);
        const orderStats = @json($orderStats ?? []);
        const isMobile = window.innerWidth < 768;

        // تكوين الألوان
        const chartColors = {
            primary: '#4338CA',
            success: '#059669',
            info: '#0284C7',
            danger: '#DC2626',
            light: 'rgba(67, 56, 202, 0.1)'
        };

        // الإعدادات المشتركة للرسوم البيانية
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: isMobile ? 500 : 1000
            },
            layout: {
                padding: isMobile ? 10 : 20
            },
            plugins: {
                tooltip: {
                    enabled: true,
                    mode: 'index',
                    intersect: false,
                    rtl: true,
                    textDirection: 'rtl',
                    titleAlign: 'right',
                    bodyAlign: 'right',
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1F2937',
                    bodyColor: '#4B5563',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    padding: isMobile ? 8 : 10,
                    bodyFont: {
                        family: 'Tajawal',
                        size: isMobile ? 11 : 12
                    },
                    titleFont: {
                        family: 'Tajawal',
                        size: isMobile ? 12 : 13,
                        weight: 'bold'
                    }
                }
            }
        };

        // إعداد الرسم البياني للمبيعات
        const salesCtx = document.getElementById('salesChart')?.getContext('2d');
        if (salesCtx) {
            const salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'المبيعات (ريال)',
                        data: chartData,
                        borderColor: chartColors.primary,
                        backgroundColor: chartColors.light,
                        tension: 0.4,
                        fill: true,
                        pointRadius: isMobile ? 2 : 3,
                        pointHoverRadius: isMobile ? 3 : 4
                    }]
                },
                options: {
                    ...commonOptions,
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    },
                    plugins: {
                        ...commonOptions.plugins,
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                callback: value => value.toFixed(2) + ' ريال',
                                font: {
                                    family: 'Tajawal',
                                    size: isMobile ? 10 : 12
                                },
                                maxTicksLimit: isMobile ? 5 : 8,
                                padding: 8
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    family: 'Tajawal',
                                    size: isMobile ? 10 : 12
                                },
                                maxRotation: isMobile ? 45 : 0,
                                minRotation: isMobile ? 45 : 0,
                                maxTicksLimit: isMobile ? 6 : 10,
                                padding: 5
                            }
                        }
                    }
                }
            });
        }

        // إعداد الرسم البياني لحالات الطلبات
        const statusCtx = document.getElementById('orderStatusChart')?.getContext('2d');
        if (statusCtx && Object.keys(orderStats).length > 0) {
            const statusLabels = {
                'pending': 'قيد الانتظار',
                'processing': 'قيد المعالجة',
                'completed': 'مكتمل',
                'cancelled': 'ملغي'
            };

            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(orderStats).map(status => statusLabels[status] || status),
                    datasets: [{
                        data: Object.values(orderStats),
                        backgroundColor: [
                            chartColors.primary,
                            chartColors.success,
                            chartColors.info,
                            chartColors.danger
                        ],
                        borderWidth: isMobile ? 1 : 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    ...commonOptions,
                    cutout: '60%',
                    plugins: {
                        ...commonOptions.plugins,
                        legend: {
                            position: isMobile ? 'bottom' : 'right',
                            rtl: true,
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: isMobile ? 15 : 20,
                                font: {
                                    family: 'Tajawal',
                                    size: isMobile ? 11 : 12
                                }
                            }
                        }
                    }
                }
            });
        }

        // تحسين أداء تحديث الرسوم البيانية عند تغيير حجم النافذة
        let resizeTimeout;
        const debouncedResize = () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const newIsMobile = window.innerWidth < 768;
                if (newIsMobile !== isMobile) {
                    Chart.instances.forEach(chart => {
                        const isDonut = chart.config.type === 'doughnut';

                        // تحديث الخيارات المشتركة
                        chart.options.animation.duration = newIsMobile ? 500 : 1000;
                        chart.options.layout.padding = newIsMobile ? 10 : 20;

                        // تحديث خيارات الخط
                        if (!isDonut) {
                            chart.options.scales.x.ticks.maxRotation = newIsMobile ? 45 : 0;
                            chart.options.scales.x.ticks.maxTicksLimit = newIsMobile ? 6 : 10;
                            chart.options.scales.y.ticks.maxTicksLimit = newIsMobile ? 5 : 8;
                            chart.data.datasets[0].pointRadius = newIsMobile ? 2 : 3;
                            chart.data.datasets[0].pointHoverRadius = newIsMobile ? 3 : 4;
                        }

                        // تحديث موضع legend للرسم البياني الدائري
                        if (isDonut) {
                            chart.options.plugins.legend.position = newIsMobile ? 'bottom' : 'right';
                        }

                        chart.update('none');
                    });
                }
            }, 250);
        };

        window.addEventListener('resize', debouncedResize);
    });

    // Sidebar Toggle Functionality
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        sidebarOverlay.classList.toggle('active');
        document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
    }

    // Toggle on button click
    sidebarToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleSidebar();
    });

    // Close on overlay click
    sidebarOverlay.addEventListener('click', toggleSidebar);

    // Close on outside click
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 992) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    });

    // Handle resize
    window.addEventListener('resize', () => {
        if (window.innerWidth > 992) {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    </script>
</x-app-layout>
