@extends('layouts.admin')

@section('title', 'تفاصيل الطلب #' . $order->id)
@section('page_title', 'تفاصيل الطلب #' . $order->id)

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid px-0">
            <div class="row mx-0">
                <div class="col-12 px-0">
                    <div class="orders-container">
                        <!-- Header Actions -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title mb-1 d-flex align-items-center">
                                                <span class="icon-circle bg-primary text-white me-2">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                تفاصيل الطلب #{{ $order->id }}
                                            </h5>
                                            <p class="text-muted mb-0 fs-sm">عرض تفاصيل الطلب والمنتجات والمواعيد</p>
                </div>
                                        <div class="actions d-flex gap-2">
                                            <a href="{{ route('admin.orders.index') }}" class="btn btn-light-secondary">
                                                <i class="fas fa-arrow-right me-2"></i>
                                                عودة للطلبات
                </a>
                                            <button onclick="window.print()" class="btn btn-light-primary">
                                                <i class="fas fa-print me-2"></i>
                    طباعة الطلب
                </button>
            </div>
                            </div>
                        </div>
                    </div>
                </div>

                        <!-- Order Stats -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm stat-card bg-gradient-primary h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white text-primary me-3">
                                                <i class="fas fa-shopping-cart fa-lg"></i>
                        </div>
                                            <div>
                                                <h6 class="text-white mb-1">رقم الطلب</h6>
                                                <h3 class="text-white mb-0">#{{ $order->id }}</h3>
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
                                                <i class="fas fa-box-open fa-lg"></i>
                                    </div>
                                    <div>
                                                <h6 class="text-white mb-1">عدد المنتجات</h6>
                                                <h3 class="text-white mb-0">{{ $order->items->count() }}</h3>
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
                                                <h6 class="text-white mb-1">إجمالي الطلب</h6>
                                                <h3 class="text-white mb-0">{{ number_format($order->total_amount) }} ريال</h3>
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
                                                <h6 class="text-white mb-1">تاريخ الطلب</h6>
                                                <h3 class="text-white mb-0">{{ $order->created_at->format('Y/m/d') }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div class="row g-4">
                            <!-- Order Info -->
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4 d-flex align-items-center">
                                            <span class="icon-circle bg-primary text-white me-2">
                                                <i class="fas fa-info-circle"></i>
                                            </span>
                                            معلومات الطلب
                                        </h5>
                                        <div class="info-list">
                                            <div class="info-item d-flex justify-content-between py-2">
                                                <span class="text-muted">حالة الطلب</span>
                                                <div>
                                                    <select name="order_status" class="form-select form-select-sm d-inline-block w-auto me-2"
                                                            onchange="this.form.submit()" form="update-status-form">
                                                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                                                        <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>مكتمل</option>
                                                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                                    </select>
                                                    <span class="badge bg-{{ $order->status_color }}-subtle text-{{ $order->status_color }} rounded-pill">
                                                        {{ $order->status_text }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="info-item d-flex justify-content-between py-2">
                                                <span class="text-muted">طريقة الدفع</span>
                                                <span>{{ $order->payment_method === 'cash' ? 'كاش' : 'بطاقة' }}</span>
                                            </div>
                                            <div class="info-item d-flex justify-content-between py-2">
                                                <span class="text-muted">حالة الدفع</span>
                                                <div>
                                                    <select name="payment_status" class="form-select form-select-sm d-inline-block w-auto me-2"
                                                            onchange="this.form.submit()" form="update-payment-status-form">
                                                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>تم الدفع</option>
                                                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>فشل الدفع</option>
                                                    </select>
                                                    <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'pending' ? 'warning' : 'danger') }}-subtle
                                                                 text-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'pending' ? 'warning' : 'danger') }} rounded-pill">
                                                        {{ $order->payment_status === 'paid' ? 'تم الدفع' : ($order->payment_status === 'pending' ? 'قيد الانتظار' : 'فشل الدفع') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                    </div>
                </div>
                            </div>

                            <!-- Customer Info -->
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4 d-flex align-items-center">
                                            <span class="icon-circle bg-primary text-white me-2">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            معلومات العميل
                                        </h5>
                                        <div class="customer-info">
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="avatar-circle bg-primary text-white me-3">
                                                    {{ substr($order->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $order->user->name }}</h6>
                                                    <p class="text-muted mb-0">{{ $order->user->email }}</p>
                                                </div>
                                            </div>
                                            <div class="info-list">
                                                <div class="info-item d-flex align-items-center py-2">
                                                    <i class="fas fa-phone text-primary me-3"></i>
                                                    <span>{{ $order->phone }}</span>
                                                </div>
                                                <div class="info-item d-flex align-items-center py-2">
                                                    <i class="fas fa-map-marker-alt text-primary me-3"></i>
                                                    <span>{{ $order->shipping_address }}</span>
                                                </div>
                                                @if($order->notes)
                                                <div class="info-item d-flex align-items-center py-2">
                                                    <i class="fas fa-sticky-note text-primary me-3"></i>
                                                    <span>{{ $order->notes }}</span>
            </div>
            @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                </div>

                            <!-- Products List -->
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                <div class="card-body">
                                        <h5 class="card-title mb-4 d-flex align-items-center">
                                            <span class="icon-circle bg-primary text-white me-2">
                                                <i class="fas fa-shopping-cart"></i>
                                            </span>
                                            المنتجات
                                        </h5>
                    <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="bg-light">
                                <tr>
                                                        <th class="border-0 text-center" style="width: 60px">#</th>
                                                        <th class="border-0" style="min-width: 250px">المنتج</th>
                                                        <th class="border-0 text-center" style="width: 100px">الكمية</th>
                                                        <th class="border-0" style="width: 150px">السعر</th>
                                                        <th class="border-0" style="width: 150px">الإجمالي</th>
                                                        <th class="border-0" style="width: 250px">الموعد</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    @if($item->product->image)
                                                                        <img src="{{ asset($item->product->image) }}"
                                                                             class="product-image border"
                                                                             width="60" height="60"
                                                                             alt="{{ $item->product->name }}">
                                                                    @else
                                                                        <div class="product-image border d-flex align-items-center justify-content-center bg-light">
                                                                            <i class="fas fa-box text-muted fa-lg"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="mb-1 fw-bold">{{ $item->product->name }}</h6>
                                                                    @if($item->product->category)
                                                                        <span class="badge bg-primary-subtle text-primary">
                                                                            {{ $item->product->category->name }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark fw-bold">
                                            {{ $item->quantity }} قطعة
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                                            <span class="fw-bold">{{ number_format($item->unit_price) }}</span>
                                            <small class="text-muted ms-1">ريال</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calculator text-primary me-2"></i>
                                            <span class="fw-bold">{{ number_format($item->subtotal) }}</span>
                                            <small class="text-muted ms-1">ريال</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->appointment)
                                            <div class="appointment-card">
                                                <div class="appointment-header">
                                                    <span class="appointment-date">
                                                        <i class="fas fa-calendar-alt text-info me-2"></i>
                                                {{ $item->appointment->appointment_date->format('Y/m/d') }}
                                            </span>
                                                </div>
                                                <div class="appointment-status mt-2">
                                                    @if($item->appointment->status === 'approved')
                                                        <div class="status-badge status-approved">
                                                            <i class="fas fa-check-circle"></i>
                                                            تم التأكيد
                                                        </div>
                                                    @else
                                                        <div class="status-badge ">
                                                            <i class="fas fa-clock"></i>
                                                            قيد الانتظار
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="appointment-card no-appointment">
                                                <div class="status-badge status-none">
                                                    <i class="fas fa-times-circle"></i>
                                                    لا يوجد موعد
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                                                <tfoot class="bg-light">
                                <tr>
                                                        <td colspan="4" class="text-end fw-bold">الإجمالي الكلي</td>
                                                        <td colspan="2">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-money-bill-wave text-success me-2"></i>
                                                                <span class="text-primary fs-5 fw-bold">{{ number_format($order->total_amount) }}</span>
                                                                <small class="text-muted ms-1">ريال</small>
                                                            </div>
                                                        </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Forms for Status Updates -->
<form id="update-status-form" action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-none">
    @csrf
    @method('PUT')
</form>

<form id="update-payment-status-form" action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST" class="d-none">
    @csrf
    @method('PUT')
</form>
@endsection

@section('styles')
    <style>
/* Container Styles */
.orders-container {
    padding: 1.5rem;
    width: 100%;
}

/* Icon & Avatar Styles */
.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.icon-circle:hover {
    transform: scale(1.1);
}

.avatar-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
    font-size: 1.25rem;
    font-weight: 600;
    box-shadow: 0 0.5rem 1rem rgba(var(--primary-rgb), 0.15);
}

/* Card Styles */
.card {
    border-radius: 1rem;
    transition: all 0.3s ease;
    border: none !important;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 2rem rgba(var(--primary-rgb), 0.1) !important;
}

.stat-card {
    border-radius: 1rem;
    overflow: hidden;
    position: relative;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 100%);
    pointer-events: none;
}

/* Info List Styles */
.info-list {
            border-radius: 1rem;
    background-color: var(--bs-light);
    padding: 1.25rem;
    box-shadow: inset 0 0.125rem 0.25rem rgba(0,0,0,0.05);
}

.info-item {
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1rem 0;
    transition: all 0.3s ease;
}

.info-item:hover {
    background-color: rgba(var(--primary-rgb), 0.02);
    padding-left: 1rem;
    padding-right: 1rem;
    margin-left: -1rem;
    margin-right: -1rem;
    border-radius: 0.5rem;
}

.info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-item:first-child {
    padding-top: 0;
}

/* Table Styles */
.table {
    --bs-table-hover-bg: rgba(var(--primary-rgb), 0.02);
}

.table > thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    color: var(--bs-gray-600);
    padding: 1rem;
}

.table > tbody td {
    padding: 1rem;
    vertical-align: middle;
}

.table > tfoot td {
    padding: 1rem;
}

/* Product Image Styles */
.product-image {
    width: 60px;
    height: 60px;
    border-radius: 0.5rem;
    object-fit: cover;
    transition: all 0.3s ease;
}

.product-image:hover {
    transform: scale(1.1);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
}

/* Badge Styles */
.badge {
    font-weight: 500;
    padding: 0.5em 1em;
}

.bg-primary-subtle {
    background-color: rgba(var(--primary-rgb), 0.1);
}

.bg-success-subtle {
    background-color: rgba(var(--success-rgb), 0.1);
}

.bg-warning-subtle {
    background-color: rgba(var(--warning-rgb), 0.1);
}

.bg-info-subtle {
    background-color: rgba(var(--info-rgb), 0.1);
}

.bg-secondary-subtle {
    background-color: rgba(var(--secondary-rgb), 0.1);
}

/* Button Styles */
.btn {
    border-radius: 0.75rem;
    padding: 0.5rem 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-wave {
    position: relative;
    overflow: hidden;
}

.btn-wave::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300%;
    height: 300%;
    background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 80%);
    transform: translate(-50%, -50%) scale(0);
    opacity: 0;
    transition: transform 0.5s, opacity 0.3s;
}

.btn-wave:active::after {
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;
    transition: 0s;
}

/* Gradient Backgrounds */
.bg-gradient-primary {
    background: linear-gradient(45deg, var(--primary), #4e73df);
}

.bg-gradient-success {
    background: linear-gradient(45deg, var(--success), #1cc88a);
}

.bg-gradient-warning {
    background: linear-gradient(45deg, var(--warning), #f6c23e);
}

.bg-gradient-info {
    background: linear-gradient(45deg, var(--info), #36b9cc);
}

/* Light Button Variants */
.btn-light-primary {
    background-color: rgba(var(--primary-rgb), 0.1);
    color: var(--primary);
}

.btn-light-primary:hover {
    background-color: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(var(--primary-rgb), 0.15);
}

.btn-light-secondary {
    background-color: rgba(var(--secondary-rgb), 0.1);
    color: var(--secondary);
}

.btn-light-secondary:hover {
    background-color: var(--secondary);
            color: white;
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(var(--secondary-rgb), 0.15);
}

/* Print Styles */
@media print {
    .no-print {
        display: none !important;
    }

    .card {
        box-shadow: none !important;
        transform: none !important;
    }

    .info-list {
        box-shadow: none;
    }
}

/* Responsive Styles */
@media (max-width: 768px) {
    .orders-container {
        padding: 0.75rem;
    }

    .card-body {
        padding: 1rem !important;
    }

    .info-list {
        padding: 1rem;
    }

    .table-responsive {
        font-size: 0.875rem;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
    }

    .btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
    }

    .icon-circle {
        width: 32px;
        height: 32px;
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .product-image {
        width: 48px;
        height: 48px;
    }
}

/* تحسينات جديدة للمواعيد */
.appointment-card {
    background: var(--bs-light);
            border-radius: 1rem;
    padding: 0.75rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.appointment-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05);
}

.appointment-header {
    margin-bottom: 0.5rem;
}

.appointment-date {
    font-weight: 600;
    color: var(--info);
    font-size: 0.95rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 0.875rem;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.status-approved {
    background-color: rgba(var(--success-rgb), 0.1);
    color: var(--success);
}

.status-approved:hover {
    background-color: var(--success);
    color: white;
}

.status-pending {
    background-color: rgba(var(--warning-rgb), 0.1);
    color: var(--warning);
}

.status-pending:hover {
    background-color: var(--warning);
    color: white;
}

.status-none {
    background-color: rgba(var(--secondary-rgb), 0.1);
    color: var(--secondary);
}

.status-none:hover {
    background-color: var(--secondary);
    color: white;
}

.no-appointment {
    opacity: 0.7;
}

.no-appointment:hover {
    opacity: 1;
}

/* تحسينات الجدول */
.table > tbody tr:hover .appointment-card {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
}

/* تحسينات التجاوب */
        @media (max-width: 768px) {
    .appointment-card {
        padding: 0.5rem;
    }

    .status-badge {
        padding: 0.35rem 0.5rem;
        font-size: 0.75rem;
    }

    .appointment-date {
        font-size: 0.875rem;
            }
        }
    </style>
@endsection
