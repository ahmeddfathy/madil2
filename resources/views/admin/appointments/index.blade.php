<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المواعيد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/appointments.css') }}">
</head>
<body class="bg-light">

<div class="appointments-container">
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="page-header">
                <h1 class="page-title mb-0">
                    <i class="fas fa-calendar-check"></i>
                    إدارة المواعيد
                </h1>
                <p class="text-muted mt-2 mb-0">قم بإدارة وتتبع جميع المواعيد من مكان واحد</p>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card mb-4 border-0 shadow-sm">
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
                        <button type="submit" class="btn btn-primary w-100 shadow">
                            <i class="fas fa-filter me-2"></i>
                            تصفية
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="card border-0 shadow">
            <div class="card-body p-0">
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

                <!-- Pagination -->
                @if($appointments->hasPages())
                <div class="pagination-container px-4">
                    {{ $appointments->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
