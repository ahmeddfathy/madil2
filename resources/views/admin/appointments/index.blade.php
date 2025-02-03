@extends('layouts.admin')

@section('title', 'إدارة المواعيد')
@section('page_title', 'إدارة المواعيد')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid px-0">
            <div class="row mx-0">
                <div class="col-12 px-0">
                    <div class="appointments-container">
                        <!-- Filters Card -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-3">
                                    <i class="fas fa-filter text-primary me-2"></i>
                                    تصفية المواعيد
                                </h5>
                                <form action="{{ route('admin.appointments.index') }}" method="GET" class="row g-3">
                                    <!-- Status Filter -->
                                    <div class="col-md-3">
                                        <label for="status" class="form-label">
                                            <i class="fas fa-tag me-1 text-primary"></i>
                                            الحالة
                                        </label>
                                        <select name="status" id="status" class="form-select shadow-sm">
                                            <option value="">كل الحالات</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>تم الموافقة</option>
                                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                        </select>
                                    </div>

                                    <!-- Date Filter -->
                                    <div class="col-md-3">
                                        <label for="date" class="form-label">
                                            <i class="fas fa-calendar me-1 text-primary"></i>
                                            التاريخ
                                        </label>
                                        <input type="date" class="form-control shadow-sm" id="date" name="date" value="{{ request('date') }}">
                                    </div>

                                    <!-- Search Filter -->
                                    <div class="col-md-4">
                                        <label for="search" class="form-label">
                                            <i class="fas fa-search me-1 text-primary"></i>
                                            بحث
                                        </label>
                                        <input type="text" class="form-control shadow-sm" id="search" name="search"
                                               placeholder="ابحث باسم العميل أو البريد الإلكتروني..."
                                               value="{{ request('search') }}">
                                    </div>

                                    <!-- Filter Button -->
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                            <i class="fas fa-filter me-2"></i>
                                            تصفية
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Appointments Table -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body px-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="border-0 py-3 ps-4">العميل</th>
                                                <th class="border-0 py-3">الخدمة</th>
                                                <th class="border-0 py-3">التاريخ والوقت</th>
                                                <th class="border-0 py-3">الحالة</th>
                                                <th class="border-0 py-3 pe-4">الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($appointments as $appointment)
                                            <tr class="align-middle">
                                                <td class="ps-4">
                                                    <div class="customer-info">
                                                        <div class="name fw-bold text-dark">
                                                            <i class="fas fa-user-circle me-1 text-primary"></i>
                                                            {{ $appointment->user->name }}
                                                        </div>
                                                        <div class="email text-muted">
                                                            <i class="fas fa-envelope me-1"></i>
                                                            {{ $appointment->user->email }}
                                                        </div>
                                                        <div class="phone text-muted mt-1">
                                                            <i class="fas fa-phone me-1"></i>
                                                            {{ $appointment->user->phone ?? 'غير محدد' }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="service-info">
                                                        <span class="service-badge mb-2">
                                                            <i class="fas fa-briefcase me-1"></i>
                                                            {{ $appointment->service_type }}
                                                        </span>
                                                        @if($appointment->price)
                                                        <div class="service-price text-muted mt-2">
                                                            <i class="fas fa-tag me-1"></i>
                                                            {{ number_format($appointment->price, 2) }} ريال
                                                        </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="datetime-info">
                                                        <div class="date fw-bold text-dark">
                                                            <i class="far fa-calendar me-1"></i>
                                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M, Y') }}
                                                        </div>
                                                        <div class="time text-muted">
                                                            <i class="far fa-clock me-1"></i>
                                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                                        </div>
                                                        @if($appointment->duration)
                                                        <div class="duration text-muted mt-1">
                                                            <i class="fas fa-hourglass-half me-1"></i>
                                                            {{ $appointment->duration }} دقيقة
                                                        </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-info">
                                                        <span class="status-badge {{ $appointment->status }}">
                                                            <i class="fas fa-circle status-icon"></i>
                                                            @switch($appointment->status)
                                                                @case('pending')
                                                                    قيد الانتظار
                                                                    @break
                                                                @case('approved')
                                                                    تم الموافقة
                                                                    @break
                                                                @case('completed')
                                                                    مكتمل
                                                                    @break
                                                                @case('cancelled')
                                                                    ملغي
                                                                    @break
                                                                @default
                                                                    {{ $appointment->status }}
                                                            @endswitch
                                                        </span>
                                                        @if($appointment->payment_status)
                                                        <div class="payment-status mt-2">
                                                            <span class="badge {{ $appointment->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                                                <i class="fas {{ $appointment->payment_status == 'paid' ? 'fa-check-circle' : 'fa-clock' }} me-1"></i>
                                                                {{ $appointment->payment_status == 'paid' ? 'تم الدفع' : 'في انتظار الدفع' }}
                                                            </span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="pe-4">
                                                    <div class="d-flex flex-column gap-2">
                                                        <a href="{{ route('admin.appointments.show', $appointment) }}"
                                                           class="btn btn-sm btn-light-primary">
                                                            <i class="fas fa-eye me-1"></i>
                                                            عرض التفاصيل
                                                        </a>
                                                        @if($appointment->status == 'pending')
                                                        <form action="{{ route('admin.appointments.updateStatus', $appointment) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit" class="btn btn-sm btn-light-success w-100">
                                                                <i class="fas fa-check me-1"></i>
                                                                قبول
                                                            </button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5">
                                                    <div class="empty-state">
                                                        <i class="fas fa-calendar-xmark text-muted mb-3"></i>
                                                        <h4 class="text-dark mb-1">لا توجد مواعيد</h4>
                                                        <p class="text-muted mb-0">لم يتم العثور على أي مواعيد تطابق معايير البحث</p>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if($appointments->hasPages())
                                <div class="pagination-container px-4 py-3 border-top">
                                    {{ $appointments->links() }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/appointments.css') }}">
<style>
.content-wrapper {
    min-height: 100vh;
    width: 100%;
    background: var(--background);
    padding: 0;
}

.content-header {
    padding: 0;
    background: transparent;
    width: 100%;
}

.container-fluid {
    max-width: 100%;
    padding: 0;
    margin: 0;
}

.appointments-container {
    padding: 1.5rem;
    width: 100%;
}

.row {
    margin: 0;
    width: 100%;
}

.col-12 {
    padding: 0;
}

.card {
    margin-bottom: 1.5rem;
    border-radius: 0.5rem;
    width: 100%;
}

.card-body {
    padding: 1.5rem;
}

.card-body.px-0 {
    padding-left: 0;
    padding-right: 0;
}

.table-responsive {
    width: 100%;
    margin: 0;
    padding: 0;
}

.table {
    width: 100%;
    margin-bottom: 0;
}

.table thead th {
    white-space: nowrap;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-badge .status-icon {
    font-size: 0.5rem;
    margin-left: 0.5rem;
}

.status-badge.pending {
    background-color: #FEF3C7;
    color: #92400E;
}

.status-badge.approved {
    background-color: #DBEAFE;
    color: #1E40AF;
}

.status-badge.completed {
    background-color: #D1FAE5;
    color: #065F46;
}

.status-badge.cancelled {
    background-color: #FEE2E2;
    color: #991B1B;
}

.service-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    background-color: #F3F4F6;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: #374151;
}

.btn-light-primary {
    background-color: #EEF2FF;
    color: var(--primary-color);
    border: none;
}

.btn-light-primary:hover {
    background-color: #E0E7FF;
    color: var(--primary-color);
}

.btn-light-success {
    background-color: #ECFDF5;
    color: var(--success-color);
    border: none;
}

.btn-light-success:hover {
    background-color: #D1FAE5;
    color: var(--success-color);
}

.empty-state {
    padding: 2rem;
    text-align: center;
}

.empty-state i {
    font-size: 3rem;
    display: block;
    margin-bottom: 1rem;
}

/* Additional Styles */
.table-container {
    width: 100%;
    overflow-x: auto;
}

.filter-container {
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .appointments-container {
        padding: 0.75rem;
    }

    .card {
        border-radius: 0;
        margin-bottom: 1rem;
    }

    .card-body {
        padding: 1rem;
    }
}
</style>
@endsection
