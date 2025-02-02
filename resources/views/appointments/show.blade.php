<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تفاصيل الموعد - Madil</title>
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
                        <h1>تفاصيل الموعد</h1>
                        <p>عرض تفاصيل الموعد وحالته</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right ms-1"></i>العودة للمواعيد
                        </a>
                    </div>
                </div>
            </div>

            <!-- Appointment Details -->
            <div class="section-card">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- معلومات الموعد -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-info-circle me-2"></i>معلومات الموعد
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="glass-effect p-3">
                                        <small class="text-muted d-block">نوع الخدمة</small>
                                        <div class="mt-1">
                                            <i class="fas fa-tag me-2"></i>
                                            {{ $appointment->service_type_text }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="glass-effect p-3">
                                        <small class="text-muted d-block">حالة الموعد</small>
                                        <div class="mt-1">
                                            <span class="badge bg-{{ $appointment->status_color }}">
                                                {{ $appointment->status_text }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="glass-effect p-3">
                                        <small class="text-muted d-block">التاريخ</small>
                                        <div class="mt-1">
                                            <i class="fas fa-calendar me-2"></i>
                                            {{ $appointment->appointment_date->format('Y/m/d') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="glass-effect p-3">
                                        <small class="text-muted d-block">الوقت</small>
                                        <div class="mt-1">
                                            <i class="fas fa-clock me-2"></i>
                                            {{ $appointment->appointment_time->format('H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- معلومات الموقع -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-map-marker-alt me-2"></i>معلومات الموقع
                            </h5>
                            <div class="glass-effect p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-primary me-2">{{ $appointment->location_text }}</span>
                                </div>
                                @if($appointment->address)
                                    <p class="mb-0">{{ $appointment->address }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- معلومات الاتصال -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-phone me-2"></i>معلومات الاتصال
                            </h5>
                            <div class="glass-effect p-3">
                                <p class="mb-0">
                                    <i class="fas fa-phone me-2"></i>{{ $appointment->phone }}
                                </p>
                            </div>
                        </div>

                        <!-- الملاحظات -->
                        @if($appointment->notes)
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-comment-alt me-2"></i>ملاحظات
                                </h5>
                                <div class="glass-effect p-3">
                                    <p class="mb-0">{{ $appointment->notes }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="glass-effect p-4">
                            <h5 class="fw-bold mb-4">الإجراءات المتاحة</h5>

                            @if($appointment->can_cancel)
                                <button class="btn btn-danger w-100 mb-3 cancel-appointment">
                                    <i class="fas fa-times me-2"></i>إلغاء الموعد
                                </button>
                            @endif



                            <div class="mt-4">
                                <h6 class="fw-bold mb-3">معلومات إضافية</h6>
                                <div class="text-muted">
                                    <p class="mb-2">
                                        <i class="fas fa-clock me-2"></i>
                                        تم الإنشاء: {{ $appointment->created_at->format('Y/m/d H:i') }}
                                    </p>
                                    @if($appointment->updated_at != $appointment->created_at)
                                        <p class="mb-0">
                                            <i class="fas fa-edit me-2"></i>
                                            آخر تحديث: {{ $appointment->updated_at->format('Y/m/d H:i') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

            $.post(`/appointments/{{ $appointment->id }}/cancel`)
                .done(function() {
                    window.location.href = '{{ route('appointments.index') }}';
                })
                .fail(function(xhr) {
                    alert(xhr.responseJSON?.message || 'حدث خطأ أثناء إلغاء الموعد');
                });
        });
    </script>
</body>
</html>
