<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>لوحة التحكم - Madil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/dashboard.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg glass-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Madil" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fas fa-home ms-1"></i>الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/products"><i class="fas fa-tshirt ms-1"></i>المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/dashboard"><i class="fas fa-user ms-1"></i>حسابي</a>
                    </li>
                </ul>
                <div class="nav-buttons d-flex align-items-center">
                    <a href="/cart" class="btn btn-link position-relative me-3">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        @if($stats['cart_items_count'] > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $stats['cart_items_count'] }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown me-3">
                        <button class="btn btn-link position-relative" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell fa-lg"></i>
                            @if($stats['unread_notifications'] > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $stats['unread_notifications'] }}
                                </span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown">
                            @forelse($recent_notifications as $notification)
                                <li>
                                    <a class="dropdown-item {{ !$notification->read_at ? 'unread' : '' }}" href="#">
                                        <i class="fas {{ $notification->icon }} me-2"></i>
                                        <div class="notification-content">
                                            <p class="mb-1">{{ $notification->data['message'] }}</p>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li><div class="dropdown-item text-center">لا توجد إشعارات</div></li>
                            @endforelse
                            @if(count($recent_notifications) > 0)
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-center" href="/notifications">عرض كل الإشعارات</a></li>
                            @endif
                        </ul>
                    </div>
                    <a href="{{ route('logout') }}" class="btn btn-outline-primary"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt ms-1"></i>تسجيل الخروج
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="dashboard-wrapper">
        <div class="container py-5">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1>مرحباً، {{ Auth::user()->name }}</h1>
                        <p>مرحباً بك في لوحة التحكم الخاصة بك</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="badge bg-primary">{{ Auth::user()->role === 'admin' ? 'مدير' : 'عميل' }}</span>
                    </div>
                </div>
            </div>

            <!-- Phone Numbers & Addresses Section -->
            <div class="row g-4 mb-5">
                <!-- Phone Numbers -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>أرقام الهاتف</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPhoneModal">
                                <i class="fas fa-plus ms-1"></i>إضافة رقم
                            </button>
                        </div>
                        <div class="card-body">
                            @if($phones->isEmpty())
                                <div class="empty-state">
                                    <i class="fas fa-phone"></i>
                                    <p>لا توجد أرقام هاتف مسجلة</p>
                                </div>
                            @else
                                <div class="list-group">
                                    @foreach($phones as $phone)
                                        <div class="list-group-item {{ $phone['is_primary'] ? 'active' : '' }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-phone me-2"></i>
                                                        <span class="phone-number">{{ $phone['phone'] }}</span>
                                                        @if($phone['is_primary'])
                                                            <span class="badge bg-warning ms-2">رئيسي</span>
                                                        @endif
                                                        <span class="badge bg-{{ $phone['type_color'] }} ms-2">{{ $phone['type_text'] }}</span>
                                                    </div>
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        تم الإضافة: {{ $phone['created_at'] }}
                                                    </small>
                                                </div>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-outline-primary edit-phone"
                                                            data-id="{{ $phone['id'] }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editPhoneModal"
                                                            title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @if(!$phone['is_primary'])
                                                        <button class="btn btn-sm btn-outline-warning make-primary-phone"
                                                                data-id="{{ $phone['id'] }}"
                                                                title="تعيين كرقم رئيسي">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-sm btn-outline-danger delete-phone"
                                                            data-id="{{ $phone['id'] }}"
                                                            title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Addresses -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>العناوين</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                <i class="fas fa-plus ms-1"></i>إضافة عنوان
                            </button>
                        </div>
                        <div class="card-body">
                            @if($addresses->isEmpty())
                                <div class="empty-state">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <p>لا توجد عناوين مسجلة</p>
                                </div>
                            @else
                                <div class="list-group">
                                    @foreach($addresses as $address)
                                        <div class="list-group-item {{ $address['is_primary'] ? 'active' : '' }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-map-marker-alt me-2"></i>
                                                        @if($address['is_primary'])
                                                            <span class="badge bg-warning me-2">رئيسي</span>
                                                        @endif
                                                        <span class="badge bg-{{ $address['type_color'] }} me-2">{{ $address['type_text'] }}</span>
                                                    </div>
                                                    <p class="mb-1 mt-2">{{ $address['full_address'] }}</p>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        تم الإضافة: {{ $address['created_at'] }}
                                                    </small>
                                                </div>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-outline-primary edit-address"
                                                            data-id="{{ $address['id'] }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editAddressModal"
                                                            title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @if(!$address['is_primary'])
                                                        <button class="btn btn-sm btn-outline-warning make-primary-address"
                                                                data-id="{{ $address['id'] }}"
                                                                title="تعيين كعنوان رئيسي">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-sm btn-outline-danger delete-address"
                                                            data-id="{{ $address['id'] }}"
                                                            title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-3 col-sm-6">
                    <div class="dashboard-card orders">
                        <div class="card-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="card-info">
                            <h3>{{ $stats['orders_count'] }}</h3>
                            <p>الطلبات</p>
                        </div>
                        <div class="card-arrow">
                            <a href="/orders" class="stretched-link">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="dashboard-card appointments">
                        <div class="card-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="card-info">
                            <h3>{{ $stats['appointments_count'] }}</h3>
                            <p>المواعيد</p>
                        </div>
                        <div class="card-arrow">
                            <a href="/appointments" class="stretched-link">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="dashboard-card cart">
                        <div class="card-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="card-info">
                            <h3>{{ $stats['cart_items_count'] }}</h3>
                            <p>منتجات في السلة</p>
                        </div>
                        <div class="card-arrow">
                            <a href="/cart" class="stretched-link">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="dashboard-card notifications">
                        <div class="card-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="card-info">
                            <h3>{{ $stats['unread_notifications'] }}</h3>
                            <p>إشعارات جديدة</p>
                        </div>
                        <div class="card-arrow">
                            <a href="/notifications" class="stretched-link">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Recent Orders -->
                <div class="col-lg-6">
                    <div class="section-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>آخر الطلبات</h2>
                            <a href="/orders" class="btn btn-outline-primary btn-sm">
                                عرض الكل <i class="fas fa-arrow-left me-1"></i>
                            </a>
                        </div>
                        @if(count($recent_orders) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>رقم الطلب</th>
                                            <th>التاريخ</th>
                                            <th>الحالة</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recent_orders as $order)
                                            <tr>
                                                <td>#{{ $order->id }}</td>
                                                <td>{{ $order->created_at->format('Y/m/d') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $order->status_color }}">
                                                        {{ $order->status_text }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="/orders/{{ $order->id }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-shopping-bag"></i>
                                <p>لا توجد طلبات حتى الآن</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Upcoming Appointments -->
                <div class="col-lg-6">
                    <div class="section-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>المواعيد القادمة</h2>
                            <a href="/appointments" class="btn btn-outline-primary btn-sm">
                                عرض الكل <i class="fas fa-arrow-left me-1"></i>
                            </a>
                        </div>
                        @if(count($upcoming_appointments) > 0)
                            <div class="appointments-grid">
                                @foreach($upcoming_appointments as $appointment)
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
                                            <h5>{{ $appointment->service_type }}</h5>
                                            <p class="location">
                                                <i class="fas fa-map-marker-alt me-2"></i>
                                                {{ $appointment->location === 'store' ? 'في المحل' : 'موقع العميل' }}
                                            </p>
                                            <div class="status">
                                                <span class="badge bg-{{ $appointment->status_color }}">
                                                    {{ $appointment->status_text }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="appointment-footer">
                                            <a href="/appointments/{{ $appointment->id }}" class="btn btn-primary btn-sm">
                                                التفاصيل <i class="fas fa-arrow-left me-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-calendar-check"></i>
                                <p>لا توجد مواعيد قادمة</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Phone Modal -->
    <div class="modal fade" id="addPhoneModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة رقم هاتف</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal"></button>
                </div>
                <form id="addPhoneForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">النوع</label>
                            <select class="form-select" name="type" required>
                                @foreach(App\Models\PhoneNumber::TYPES as $value => $text)
                                    <option value="{{ $value }}">{{ $text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة عنوان</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal"></button>
                </div>
                <form id="addAddressForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">النوع</label>
                            <select class="form-select" name="type" required>
                                @foreach(App\Models\Address::TYPES as $value => $text)
                                    <option value="{{ $value }}">{{ $text }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">المدينة</label>
                            <input type="text" class="form-control" name="city" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">المنطقة</label>
                            <input type="text" class="form-control" name="area" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الشارع</label>
                            <input type="text" class="form-control" name="street" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">رقم المبنى</label>
                            <input type="text" class="form-control" name="building_no">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">تفاصيل إضافية</label>
                            <textarea class="form-control" name="details" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Phone Modal -->
    <div class="modal fade" id="editPhoneModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تعديل رقم الهاتف</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal"></button>
                </div>
                <form id="editPhoneForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">النوع</label>
                            <select class="form-select" name="type" required>
                                @foreach(App\Models\PhoneNumber::TYPES as $value => $text)
                                    <option value="{{ $value }}">{{ $text }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="phone_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Address Modal -->
    <div class="modal fade" id="editAddressModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تعديل العنوان</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal"></button>
                </div>
                <form id="editAddressForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">النوع</label>
                            <select class="form-select" name="type" required>
                                @foreach(App\Models\Address::TYPES as $value => $text)
                                    <option value="{{ $value }}">{{ $text }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">المدينة</label>
                            <input type="text" class="form-control" name="city" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">المنطقة</label>
                            <input type="text" class="form-control" name="area" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الشارع</label>
                            <input type="text" class="form-control" name="street" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">رقم المبنى</label>
                            <input type="text" class="form-control" name="building_no">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">تفاصيل إضافية</label>
                            <textarea class="form-control" name="details" rows="3"></textarea>
                        </div>
                        <input type="hidden" name="address_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // تهيئة CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ==================== وظائف أرقام الهواتف ====================

        // إضافة رقم هاتف
        $('#addPhoneForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();

            $.post('/phones', formData)
                .done(function(response) {
                    $('#addPhoneModal').modal('hide');
                    location.reload();
                })
                .fail(function(xhr) {
                    alert(xhr.responseJSON?.message || 'حدث خطأ أثناء إضافة رقم الهاتف');
                });
        });

        // تحميل بيانات الهاتف للتعديل
        $('.edit-phone').on('click', function() {
            const id = $(this).data('id');

            $.get(`/phones/${id}`)
                .done(function(phone) {
                    const form = $('#editPhoneForm');
                    form.find('input[name="phone"]').val(phone.phone);
                    form.find('select[name="type"]').val(phone.type);
                    form.find('input[name="phone_id"]').val(phone.id);
                })
                .fail(function() {
                    alert('حدث خطأ أثناء تحميل بيانات رقم الهاتف');
                });
        });

        // تعديل رقم الهاتف
        $('#editPhoneForm').on('submit', function(e) {
            e.preventDefault();
            const id = $(this).find('input[name="phone_id"]').val();
            const formData = $(this).serialize();

            $.ajax({
                url: `/phones/${id}`,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    $('#editPhoneModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'حدث خطأ أثناء تعديل رقم الهاتف');
                }
            });
        });

        // حذف رقم الهاتف
        $('.delete-phone').on('click', function() {
            if (!confirm('هل أنت متأكد من حذف هذا الرقم؟')) return;

            const id = $(this).data('id');
            $.ajax({
                url: `/phones/${id}`,
                type: 'DELETE',
                success: function() {
                    location.reload();
                },
                error: function() {
                    alert('حدث خطأ أثناء حذف رقم الهاتف');
                }
            });
        });

        // ==================== وظائف العناوين ====================

        // إضافة عنوان
        $('#addAddressForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();

            $.post('/addresses', formData)
                .done(function(response) {
                    $('#addAddressModal').modal('hide');
                    location.reload();
                })
                .fail(function(xhr) {
                    alert(xhr.responseJSON?.message || 'حدث خطأ أثناء إضافة العنوان');
                });
        });

        // تحميل بيانات العنوان للتعديل
        $('.edit-address').on('click', function() {
            const id = $(this).data('id');

            $.get(`/addresses/${id}`)
                .done(function(address) {
                    const form = $('#editAddressForm');
                    form.find('select[name="type"]').val(address.type);
                    form.find('input[name="city"]').val(address.city);
                    form.find('input[name="area"]').val(address.area);
                    form.find('input[name="street"]').val(address.street);
                    form.find('input[name="building_no"]').val(address.building_no);
                    form.find('textarea[name="details"]').val(address.details);
                    form.find('input[name="address_id"]').val(address.id);
                })
                .fail(function() {
                    alert('حدث خطأ أثناء تحميل بيانات العنوان');
                });
        });

        // تعديل العنوان
        $('#editAddressForm').on('submit', function(e) {
            e.preventDefault();
            const id = $(this).find('input[name="address_id"]').val();
            const formData = $(this).serialize();

            $.ajax({
                url: `/addresses/${id}`,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    $('#editAddressModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'حدث خطأ أثناء تعديل العنوان');
                }
            });
        });

        // حذف العنوان
        $('.delete-address').on('click', function() {
            if (!confirm('هل أنت متأكد من حذف هذا العنوان؟')) return;

            const id = $(this).data('id');
            $.ajax({
                url: `/addresses/${id}`,
                type: 'DELETE',
                success: function() {
                    location.reload();
                },
                error: function() {
                    alert('حدث خطأ أثناء حذف العنوان');
                }
            });
        });
    </script>
</body>
</html>
