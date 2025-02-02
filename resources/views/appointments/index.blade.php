<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>المواعيد - Madil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/appointments.css') }}">
</head>
<body>
    <!-- Navbar -->

    <div class="dashboard-wrapper">
        <div class="container py-5">
            <!-- Header Section -->
            <div class="welcome-section mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1>المواعيد</h1>
                        <p>إدارة وعرض جميع المواعيد الخاصة بك</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus ms-1"></i>حجز موعد جديد
                        </a>
                    </div>
                </div>
            </div>

            <!-- Appointments Grid -->
            <div class="appointments-grid">
                @forelse($appointments as $appointment)
                    <div class="appointment-card">
                        <div class="appointment-header">
                            <div class="date">
                                <i class="fas fa-calendar me-2"></i>
                                {{ $appointment->appointment_date->format('Y/m/d') }}
                            </div>
                            <div class="time">
                                <i class="fas fa-clock me-2"></i>
                                {{ $appointment->appointment_time->format('H:i') }}
                            </div>
                        </div>
                        <div class="appointment-body">
                            <h5>{{ $appointment->service_type_text }}</h5>
                            <p class="location">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                {{ $appointment->location_text }}
                            </p>
                            <div class="status">
                                <span class="badge bg-{{ $appointment->status_color }}">
                                    {{ $appointment->status_text }}
                                </span>
                            </div>
                            @if($appointment->notes)
                                <p class="notes mt-3 text-muted">
                                    <i class="fas fa-comment-alt me-2"></i>
                                    {{ $appointment->notes }}
                                </p>
                            @endif
                        </div>
                        <div class="appointment-footer">
                            <div class="btn-group">
                                <a href="{{ route('appointments.show', $appointment) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>التفاصيل
                                </a>
                                @if($appointment->can_cancel)
                                    <button class="btn btn-sm btn-outline-danger cancel-appointment"
                                            data-id="{{ $appointment->id }}">
                                        <i class="fas fa-times me-1"></i>إلغاء
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>لا توجد مواعيد مسجلة</p>
                        <a href="{{ route('appointments.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus ms-1"></i>حجز موعد جديد
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($appointments->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // تهيئة CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // إلغاء الموعد
        $('.cancel-appointment').on('click', function() {
            if (!confirm('هل أنت متأكد من إلغاء هذا الموعد؟')) return;

            const id = $(this).data('id');
            $.post(`/appointments/${id}/cancel`)
                .done(function() {
                    location.reload();
                })
                .fail(function(xhr) {
                    alert(xhr.responseJSON?.message || 'حدث خطأ أثناء إلغاء الموعد');
                });
        });
    </script>
</body>
</html>
