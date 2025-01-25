<x-app-layout>
    <!-- تضمين ملف CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/admin-dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="admin-layout">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    Madil Admin
                </div>
            </div>

            <div class="sidebar-nav">
                <!-- Dashboard Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Main</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span class="nav-title">Dashboard</span>
                        </a>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Products</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="fas fa-box"></i>
                            <span class="nav-title">Products</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i>
                            <span class="nav-title">Categories</span>
                        </a>
                    </div>
                </div>

                <!-- Orders Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Orders</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="nav-title">Orders</span>
                        </a>
                    </div>
                </div>

                <!-- Appointments Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Appointments</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.appointments.index') }}" class="nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar"></i>
                            <span class="nav-title">Appointments</span>
                        </a>
                    </div>
                </div>

                <!-- Reports Section -->
                <div class="nav-section">
                    <div class="nav-section-title">Reports</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar"></i>
                            <span class="nav-title">Reports</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Toggle Button -->
        <div class="sidebar-toggle d-lg-none" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </div>

        <!-- Main Content -->
        <div class="main-content-wrapper">
            <div class="dashboard-wrapper">
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <!-- Orders Card -->
                    <div class="stat-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-value">{{ $stats['orders'] ?? 0 }}</div>
                        <div class="stat-title">Total Orders</div>
                        @if(!empty($monthlyGrowth))
                        <div class="trend {{ $monthlyGrowth[0] >= 0 ? 'up' : 'down' }}">
                            <i class="fas fa-arrow-{{ $monthlyGrowth[0] >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ abs($monthlyGrowth[0]) }}% {{ $monthlyGrowth[0] >= 0 ? 'increase' : 'decrease' }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Users Card -->
                    <div class="stat-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-value">{{ $stats['users'] ?? 0 }}</div>
                        <div class="stat-title">Total Users</div>
                        <div class="trend up">
                            <i class="fas fa-arrow-up"></i>
                            <span>Active Users</span>
                        </div>
                    </div>

                    <!-- Products Card -->
                    <div class="stat-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-value">{{ $stats['products'] ?? 0 }}</div>
                        <div class="stat-title">Total Products</div>
                        <div class="trend up">
                            <i class="fas fa-arrow-up"></i>
                            <span>In Stock</span>
                        </div>
                    </div>

                    <!-- Revenue Card -->
                    <div class="stat-card">
                        <div class="icon-wrapper">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-value">{{ number_format(($stats['revenue'] ?? 0) / 100, 2) }}</div>
                        <div class="stat-title">Total Revenue (SAR)</div>
                        <div class="trend up">
                            <i class="fas fa-arrow-up"></i>
                            <span>Total Sales</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    @can('create', App\Models\Product::class)
                    <a href="{{ route('admin.products.create') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <h5>Add Product</h5>
                        <p>Add new products to your store</p>
                    </a>
                    @endcan

                    @can('viewAny', App\Models\Order::class)
                    <a href="{{ route('admin.orders.index') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h5>Manage Orders</h5>
                        <p>View and manage customer orders</p>
                    </a>
                    @endcan

                    @can('viewAny', App\Models\Appointment::class)
                    <a href="{{ route('admin.appointments.index') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <h5>Appointments</h5>
                        <p>Manage customer appointments</p>
                    </a>
                    @endcan
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <!-- Sales Chart -->
                    <div class="chart-container">
                        <div class="activity-header">
                            <h5 class="activity-title">Sales Overview</h5>
                        </div>
                        <canvas id="salesChart" height="300"></canvas>
                    </div>

                    <!-- Recent Orders -->
                    <div class="activity-section">
                        <div class="activity-header">
                            <h5 class="activity-title">Recent Orders</h5>
                            @can('viewAny', App\Models\Order::class)
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">View All</a>
                            @endcan
                        </div>
                        <div class="table-responsive">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="status status-{{ $order->order_status }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($order->total_amount / 100, 2) }} SAR</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No orders found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Order Status Chart -->
                    <div class="chart-container">
                        <div class="activity-header">
                            <h5 class="activity-title">Order Status Distribution</h5>
                        </div>
                        <canvas id="orderStatusChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- تضمين Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // إغلاق Sidebar عند النقر خارجه في الشاشات الصغيرة
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.querySelector('.sidebar-toggle');

            if (window.innerWidth <= 992) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // إعداد الرسم البياني
        const salesCtx = document.getElementById('salesChart')?.getContext('2d');
        if (salesCtx) {
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: {
                        {
                            Js::from($chartLabels ?? [])
                        }
                    },
                    datasets: [{
                        label: 'Sales (SAR)',
                        data: {
                            {
                                Js::from($chartData ?? [])
                            }
                        },
                        borderColor: '#4361ee',
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(67, 97, 238, 0.1)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.parsed.y.toFixed(2)} SAR`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toFixed(2) + ' SAR';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // إضافة رسم بياني دائري لحالات الطلبات
        const statusCtx = document.getElementById('orderStatusChart')?.getContext('2d');
        const orderStats = {
            {
                Js::from($orderStats ?? [])
            }
        };

        if (statusCtx && Object.keys(orderStats).length > 0) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(orderStats).map(status => status.toUpperCase()),
                    datasets: [{
                        data: Object.values(orderStats),
                        backgroundColor: [
                            '#4361ee', // Pending
                            '#2ecc71', // Processing
                            '#f1c40f', // Completed
                            '#e74c3c' // Cancelled
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
