@extends('layouts.admin')

@section('title', 'الطلبات')
@section('page_title', 'إدارة الطلبات')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid px-0">
            <div class="row mx-0">
                <div class="col-12 px-0">
                    <div class="orders-container">
                        <!-- Stats Cards -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm stat-card bg-gradient-primary h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white text-primary me-3">
                                                <i class="fas fa-shopping-cart fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-white mb-1">إجمالي الطلبات</h6>
                                                <h3 class="text-white mb-0">{{ $orders->total() }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm stat-card bg-gradient-success h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white text-success me-3">
                                                <i class="fas fa-check-circle fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-white mb-1">الطلبات المكتملة</h6>
                                                <h3 class="text-white mb-0">{{ $orders->where('status', 'completed')->count() }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm stat-card bg-gradient-warning h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white text-warning me-3">
                                                <i class="fas fa-clock fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-white mb-1">قيد التنفيذ</h6>
                                                <h3 class="text-white mb-0">{{ $orders->where('status', 'processing')->count() }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm stat-card bg-gradient-info h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white text-info me-3">
                                                <i class="fas fa-money-bill-wave fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-white mb-1">إجمالي المبيعات</h6>
                                                <h3 class="text-white mb-0">{{ number_format($orders->sum('total') / 100, 2) }} ريال</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Header Actions -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title mb-1 d-flex align-items-center">
                                                <span class="icon-circle bg-primary text-white me-2">
                                                    <i class="fas fa-shopping-bag"></i>
                                                </span>
                                                إدارة الطلبات
                                            </h5>
                                            <p class="text-muted mb-0 fs-sm">إدارة ومتابعة طلبات العملاء</p>
                                        </div>
                                        <div class="actions d-flex gap-2">
                                            <button type="button" class="btn btn-light-primary btn-wave">
                                                <i class="fas fa-file-export me-2"></i>
                                                تصدير التقرير
                                            </button>
                                            <button type="button" class="btn btn-light-success btn-wave">
                                                <i class="fas fa-print me-2"></i>
                                                طباعة
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>

                        <!-- Search & Filters -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                <div class="card-body">
                                        <form action="{{ route('admin.orders.index') }}" method="GET">
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <div class="search-wrapper">
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light border-0">
                                                                <i class="fas fa-search text-muted"></i>
                                                            </span>
                                                            <input type="text" name="search" class="form-control border-0 shadow-none ps-0"
                                                                placeholder="البحث في الطلبات..."
                                                                value="{{ request('search') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="status" class="form-select border-0 shadow-none bg-light">
                                                        <option value="">كل الحالات</option>
                                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>قيد التنفيذ</option>
                                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" name="date" class="form-control border-0 shadow-none bg-light"
                                                           value="{{ request('date') }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-primary btn-wave w-100">
                                                        <i class="fas fa-filter me-2"></i>
                                                        تصفية
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Orders List -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="border-0 text-center">#</th>
                                                        <th class="border-0">العميل</th>
                                                        <th class="border-0">المنتجات</th>
                                                        <th class="border-0">الإجمالي</th>
                                                        <th class="border-0">الحالة</th>
                                                        <th class="border-0">التاريخ</th>
                                                        <th class="border-0">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                                    @forelse($orders as $order)
                                    <tr>
                                                        <td class="text-center">{{ $order->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-circle bg-primary text-white me-2">
                                                                    {{ substr($order->customer_name, 0, 1) }}
                                                </div>
                                                <div>
                                                                    <h6 class="mb-0">{{ $order->customer_name }}</h6>
                                                                    <small class="text-muted">{{ $order->customer_phone }}</small>
                                                </div>
                                            </div>
                                        </td>
                                                        <td>{{ $order->items_count }} منتج</td>
                                                        <td>{{ number_format($order->total / 100, 2) }} ريال</td>
                                                        <td>
                                                            <span class="badge bg-{{ $order->status_color }}-subtle text-{{ $order->status_color }} rounded-pill">
                                                                {{ $order->status_text }}
                                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('Y/m/d') }}</td>
                                        <td>
                                                            <div class="action-buttons">
                                                                <a href="{{ route('admin.orders.show', $order) }}"
                                                                   class="btn btn-light-info btn-sm me-2"
                                                                   title="عرض التفاصيل">
                                                <i class="fas fa-eye"></i>
                                            </a>


                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-5">
                                                            <div class="empty-state">
                                                                <div class="empty-icon bg-light rounded-circle mb-3">
                                                                    <i class="fas fa-shopping-cart text-muted fa-2x"></i>
                                                                </div>
                                                                <h5 class="text-muted mb-0">لا توجد طلبات</h5>
                                                            </div>
                                        </td>
                                    </tr>
                                                    @endforelse
                                </tbody>
                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if($orders->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.orders-container {
    padding: 1.5rem;
    width: 100%;
}

.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.fs-sm {
    font-size: 0.875rem;
}

/* Search & Filter Styles */
.search-wrapper {
    position: relative;
}

.search-wrapper .input-group {
    background: var(--bs-light);
    border-radius: 0.5rem;
}

.input-group-text {
    border-radius: 0.5rem 0 0 0.5rem;
    padding: 0.75rem 1rem;
}

.form-control, .form-select {
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    height: 48px;
}

.form-control:focus, .form-select:focus {
    box-shadow: none;
    background: var(--bs-light);
}

/* Card Styles */
.card {
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.stat-card {
    border-radius: 1rem;
    overflow: hidden;
}

/* Button Styles */
.btn-wave {
    position: relative;
    overflow: hidden;
    transform: translate3d(0, 0, 0);
}

.btn-wave::after {
    content: "";
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    pointer-events: none;
    background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
    background-repeat: no-repeat;
    background-position: 50%;
    transform: scale(10, 10);
    opacity: 0;
    transition: transform .5s, opacity 1s;
}

.btn-wave:active::after {
    transform: scale(0, 0);
    opacity: .3;
    transition: 0s;
}

/* Table Styles */
.table > :not(caption) > * > * {
    padding: 1rem;
}

.table > thead {
    background: var(--bs-light);
}

.table > thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

/* Action Buttons */
.action-buttons .btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-light-info {
    background-color: rgba(var(--info-rgb), 0.1);
    color: var(--info);
    border: none;
}

.btn-light-info:hover {
    background-color: var(--info);
    color: white;
}

.btn-light-primary {
    background-color: rgba(var(--primary-rgb), 0.1);
    color: var(--primary);
    border: none;
}

.btn-light-primary:hover {
    background-color: var(--primary);
    color: white;
}

.btn-light-danger {
    background-color: rgba(var(--danger-rgb), 0.1);
    color: var(--danger);
    border: none;
}

.btn-light-danger:hover {
    background-color: var(--danger);
    color: white;
}

.btn-light-success {
    background-color: rgba(var(--success-rgb), 0.1);
    color: var(--success);
    border: none;
}

.btn-light-success:hover {
    background-color: var(--success);
    color: white;
}

/* Status Colors */
.bg-gradient-primary { background: linear-gradient(45deg, var(--primary), #4e73df); }
.bg-gradient-success { background: linear-gradient(45deg, var(--success), #1cc88a); }
.bg-gradient-warning { background: linear-gradient(45deg, var(--warning), #f6c23e); }
.bg-gradient-info { background: linear-gradient(45deg, var(--info), #36b9cc); }

/* Badge Styles */
.badge {
    font-weight: 500;
    padding: 0.5em 1em;
}

/* Empty State */
.empty-state {
    padding: 2rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 768px) {
    .orders-container {
        padding: 0.75rem;
    }

    .card-body {
        padding: 1rem !important;
    }

    .action-buttons .btn {
        width: 28px;
        height: 28px;
    }

    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endsection
