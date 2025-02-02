<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>حجز موعد جديد - Madil</title>
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
                        <h1>حجز موعد جديد</h1>
                        <p>يرجى ملء النموذج التالي لحجز موعدك</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right ms-1"></i>العودة للمواعيد
                        </a>
                    </div>
                </div>
            </div>

            <!-- Appointment Form -->
            <div class="section-card">
                <form action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <!-- نوع الخدمة -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">نوع الخدمة</label>
                                <select name="service_type" class="form-select form-select-lg @error('service_type') is-invalid @enderror" required>
                                    <option value="">اختر نوع الخدمة</option>
                                    <option value="new_abaya" {{ old('service_type') == 'new_abaya' ? 'selected' : '' }}>عباية جديدة</option>
                                    <option value="alteration" {{ old('service_type') == 'alteration' ? 'selected' : '' }}>تعديل</option>
                                    <option value="repair" {{ old('service_type') == 'repair' ? 'selected' : '' }}>إصلاح</option>
                                </select>
                                @error('service_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- موقع الموعد -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">موقع الموعد</label>
                                <select name="location" class="form-select form-select-lg @error('location') is-invalid @enderror" required>
                                    <option value="store" {{ old('location') == 'store' ? 'selected' : '' }}>في المحل</option>
                                    <option value="client_location" {{ old('location') == 'client_location' ? 'selected' : '' }}>موقع العميل</option>
                                </select>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- تاريخ الموعد -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">تاريخ الموعد</label>
                                <input type="date" name="appointment_date"
                                       class="form-control form-control-lg @error('appointment_date') is-invalid @enderror"
                                       value="{{ old('appointment_date') }}" required>
                                @error('appointment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- وقت الموعد -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">وقت الموعد</label>
                                <input type="time" name="appointment_time"
                                       class="form-control form-control-lg @error('appointment_time') is-invalid @enderror"
                                       value="{{ old('appointment_time') }}" required>
                                @error('appointment_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- رقم الهاتف -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">رقم الهاتف</label>
                                <input type="tel" name="phone"
                                       class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', Auth::user()->phone) }}"
                                       placeholder="05xxxxxxxx" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- العنوان -->
                        <div class="col-md-6" id="addressField">
                            <div class="form-group">
                                <label class="form-label fw-bold">العنوان</label>
                                <textarea name="address"
                                          class="form-control form-control-lg @error('address') is-invalid @enderror"
                                          rows="3">{{ old('address', Auth::user()->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- ملاحظات -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label fw-bold">ملاحظات إضافية</label>
                                <textarea name="notes"
                                          class="form-control form-control-lg @error('notes') is-invalid @enderror"
                                          rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- زر الحفظ -->
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-calendar-check ms-1"></i>تأكيد الحجز
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // إظهار/إخفاء حقل العنوان حسب موقع الموعد
        $('select[name="location"]').on('change', function() {
            const addressField = $('#addressField');
            if (this.value === 'client_location') {
                addressField.slideDown();
                addressField.find('textarea').prop('required', true);
            } else {
                addressField.slideUp();
                addressField.find('textarea').prop('required', false);
            }
        }).trigger('change');
    </script>
</body>
</html>
