<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} - Madil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/products-show.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/products.css') }}">
</head>
<body>
    <!-- Navbar -->

    <nav class="navbar navbar-expand-lg glass-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">Madil</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">من نحن</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/products">المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">حسابي</a>
                    </li>
                </ul>
                <div class="nav-buttons">
                    <button class="btn btn-outline-primary position-relative me-2" id="cartToggle">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">
                            0
                        </span>
                    </button>
                            @auth
                                <a href="/dashboard" class="btn btn-primary">لوحة التحكم</a>
                            @else
                                <a href="/login" class="btn btn-outline-primary me-2">تسجيل الدخول</a>
                                <a href="/register" class="btn btn-primary">إنشاء حساب</a>
                            @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Add this after navbar -->
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h3>سلة التسوق</h3>
            <button class="close-cart" id="closeCart">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-items" id="cartItems">
            <!-- Cart items will be dynamically added here -->
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>الإجمالي:</span>
                <span id="cartTotal">0 ر.س</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="checkout-btn">
                <i class="fas fa-shopping-cart ml-2"></i>
                إتمام الشراء
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="/products">المنتجات</a></li>
                <li class="breadcrumb-item"><a href="/products?category={{ $product->category->id }}">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Product Images -->
            <div class="col-md-6">
                <div class="product-gallery card">
                    <div class="card-body">
                        @if($product->images->count() > 0)
                            <div class="main-image-wrapper mb-3">
                                <img src="{{ Storage::url($product->primary_image->image_path) }}"
                                    alt="{{ $product->name }}"
                                    class="main-product-image"
                                    id="mainImage">
                            </div>
                            @if($product->images->count() > 1)
                                <div class="image-thumbnails">
                                    @foreach($product->images as $image)
                                        <div class="thumbnail-wrapper {{ $image->is_primary ? 'active' : '' }}"
                                            onclick="updateMainImage('{{ Storage::url($image->image_path) }}', this)">
                                            <img src="{{ Storage::url($image->image_path) }}"
                                                alt="Product thumbnail"
                                                class="thumbnail-image">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="no-image-placeholder">
                                <i class="fas fa-image"></i>
                                <p>لا توجد صور متاحة</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <div class="product-info">
                    <h1 class="product-title">{{ $product->name }}</h1>

                    <div class="category-badge mb-3">
                        <i class="fas fa-tag me-1"></i>
                        {{ $product->category->name }}
                    </div>

                    <div class="product-price mb-4">
                        <span class="currency">ر.س</span>
                        <span class="amount">{{ number_format($product->price, 2) }}</span>
                    </div>

                    <div class="stock-info mb-4">
                        <span class="stock-badge {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                            <i class="fas {{ $product->stock > 0 ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                            {{ $product->stock > 0 ? 'متوفر' : 'غير متوفر' }}
                        </span>
                        @if($product->stock > 0)
                            <span class="stock-count">({{ $product->stock }} قطعة متوفرة)</span>
                        @endif
                    </div>

                    <div class="product-description mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-info-circle me-2"></i>
                            وصف المنتج
                        </h5>
                        <p>{{ $product->description }}</p>
                    </div>

                    <!-- Product Features Guide -->
                    <div class="features-guide mb-4">
                        <div class="alert alert-info">
                            <h6 class="alert-heading mb-3">
                                <i class="fas fa-lightbulb me-2"></i>
                                ميزات الطلب المتاحة
                            </h6>
                            <ul class="features-list mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-palette me-2"></i>
                                        يمكنك اختيار لون من الألوان المتاحة أو إضافة لون مخصص حسب رغبتك
                                    </li>

                                    <li class="mb-2">
                                        <i class="fas fa-ruler me-2"></i>
                                        يمكنك اختيار مقاس من المقاسات المتاحة أو إضافة مقاس مخصص حسب رغبتك
                                    </li>
                                <li class="mb-2">
                                    <i class="fas fa-tape me-2"></i>
                                    يمكنك طلب موعد لأخذ المقاسات إذا كنت غير متأكد من المقاس المناسب
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Colors Section -->
                    @if($product->colors && $product->colors->isNotEmpty())
                        <div class="colors-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-palette me-2"></i>
                                الألوان المتاحة
                            </h5>
                            <div class="colors-grid mb-3">
                                @foreach($product->colors as $color)
                                    <div class="color-item {{ $color->is_available ? 'available' : 'unavailable' }}"
                                        data-color="{{ $color->color }}"
                                        onclick="selectColor(this)">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="color-preview" style="background-color: {{ $color->color }}"></span>
                                            <span class="color-name">{{ $color->color }}</span>
                                        </div>
                                        <span class="color-status">
                                            @if($color->is_available)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                            <!-- إضافة حقل لون مخصص -->
                            <div class="custom-color-input mt-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="useCustomColor">
                                    <label class="form-check-label" for="useCustomColor">
                                        <i class="fas fa-edit me-1"></i>
                                        إضافة لون مخصص
                                    </label>
                                </div>
                                <div class="input-group d-none" id="customColorGroup">
                                    <input type="text" class="form-control" id="customColor" placeholder="اكتب اللون المطلوب">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="custom-color-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-palette me-2"></i>
                                اللون المطلوب
                            </h5>
                            <div class="input-group">
                                <input type="text" class="form-control" id="customColor" placeholder="اكتب اللون المطلوب">
                            </div>
                        </div>
                    @endif

                    <!-- Sizes Section -->
                    @if($product->sizes && $product->sizes->isNotEmpty())
                        <div class="sizes-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-ruler me-2"></i>
                                المقاسات المتاحة
                            </h5>
                            <div class="sizes-grid mb-3">
                                @foreach($product->sizes as $size)
                                    <div class="size-item {{ $size->is_available ? 'available' : 'unavailable' }}"
                                        data-size="{{ $size->size }}"
                                        onclick="selectSize(this)">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-ruler"></i>
                                            <span class="size-name">{{ $size->size }}</span>
                                        </div>
                                        <span class="size-status">
                                            @if($size->is_available)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                            <!-- إضافة حقل مقاس مخصص -->
                            <div class="custom-size-input mt-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="useCustomSize">
                                    <label class="form-check-label" for="useCustomSize">
                                        <i class="fas fa-edit me-1"></i>
                                        إضافة مقاس مخصص
                                    </label>
                                </div>
                                <div class="input-group d-none" id="customSizeGroup">
                                    <input type="text" class="form-control" id="customSize" placeholder="اكتب المقاس المطلوب">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="custom-size-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-ruler me-2"></i>
                                المقاس المطلوب
                            </h5>
                            <div class="input-group">
                                <input type="text" class="form-control" id="customSize" placeholder="اكتب المقاس المطلوب">
                            </div>
                        </div>
                    @endif

                    <!-- Custom Measurements Option -->
                    <div class="custom-measurements-section mb-4">
                        @auth
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="needsAppointment">
                            <label class="form-check-label" for="needsAppointment">
                                <i class="fas fa-tape me-2"></i>
                                أحتاج إلى أخذ المقاسات
                            </label>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            اختر هذا الخيار إذا كنت تريد تحديد موعد لأخذ المقاسات الخاصة بك
                        </small>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                يجب تسجيل الدخول لتتمكن من حجز موعد لأخذ المقاسات
                            </div>
                        @endauth
                    </div>

                    <!-- Quantity Selector -->
                    @auth
                    <div class="quantity-selector mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-shopping-basket me-2"></i>
                            الكمية
                        </h5>
                        <div class="input-group" style="width: 150px;">
                            <button class="btn btn-outline-primary" type="button" onclick="updatePageQuantity(-1)">-</button>
                            <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="{{ $product->stock }}" readonly>
                            <button class="btn btn-outline-primary" type="button" onclick="updatePageQuantity(1)">+</button>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <button class="btn btn-primary btn-lg w-100 mb-4" onclick="addToCart()">
                        <i class="fas fa-shopping-cart me-2"></i>
                        أضف إلى السلة
                    </button>
                    @else
                        <!-- Login to Order Button -->
                        <button class="btn btn-primary btn-lg w-100 mb-4" onclick="showLoginPrompt('{{ route('login') }}')">
                            <i class="fas fa-shopping-cart me-2"></i>
                            تسجيل الدخول للطلب
                        </button>
                    @endauth

                    <!-- Error Messages -->
                    <div class="alert alert-danger d-none" id="errorMessage"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="glass-footer mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>عن Madil</h5>
                    <p>متجرك المفضل للمنتجات المميزة بأفضل الأسعار وأعلى جودة.</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="/privacy">سياسة الخصوصية</a></li>
                        <li><a href="/terms">الشروط والأحكام</a></li>
                        <li><a href="/shipping">معلومات الشحن</a></li>
                        <li><a href="/faq">الأسئلة الشائعة</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>تواصل معنا</h5>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-0">&copy; {{ date('Y') }} Madil. جميع الحقوق محفوظة</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal for Appointment -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <button type="button" class="btn-close btn-close-white ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h5 class="modal-title">حجز موعد للمقاسات</h5>
                </div>
                <div class="modal-body">
                    <form id="appointmentForm" class="appointment-form">
                        @csrf
                        <input type="hidden" name="service_type" value="new_abaya">
                        <input type="hidden" name="cart_item_id" id="cart_item_id">

                        <div class="mb-4">
                            <label for="appointment_date" class="form-label fw-bold">تاريخ الموعد</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" class="form-control form-control-lg" id="appointment_date"
                                       name="appointment_date" min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="appointment_time" class="form-label fw-bold">وقت الموعد</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                <input type="time" class="form-control form-control-lg" id="appointment_time"
                                       name="appointment_time" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="location" class="form-label fw-bold">الموقع</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <select class="form-select form-select-lg" id="location" name="location"
                                        required onchange="toggleAddress()">
                                    <option value="store">في المحل</option>
                                    <option value="client_location">موقع العميل</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4 d-none" id="addressField">
                            <label for="address" class="form-label fw-bold">العنوان</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                <textarea class="form-control" id="address" name="address"
                                          rows="3" placeholder="يرجى إدخال العنوان بالتفصيل"></textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="form-label fw-bold">رقم الهاتف</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-control form-control-lg" id="phone"
                                       name="phone" value="{{ Auth::user()->phone ?? '' }}"
                                       placeholder="01xxxxxxxxx" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">ملاحظات</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                <textarea class="form-control" id="notes" name="notes" rows="3"
                                          placeholder="أي ملاحظات إضافية؟"></textarea>
                            </div>
                        </div>

                        <div id="appointmentErrors" class="alert alert-danger d-none"></div>

                        <button type="submit" class="btn btn-primary btn-lg w-100" id="submitAppointment">
                            <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                            تأكيد الحجز
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Prompt Modal -->
    <div class="modal fade" id="loginPromptModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تسجيل الدخول مطلوب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>يجب عليك تسجيل الدخول أولاً لتتمكن من طلب المنتج</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <a href="" class="btn btn-primary" id="loginButton">تسجيل الدخول</a>
                </div>
            </div>
        </div>
    </div>

    <style>
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        background-color: #ffffff;
    }

    .modal-header {
        border-radius: 15px 15px 0 0;
        padding: 1.5rem;
        background-color: #1a73e8;
        display: flex;
        flex-direction: row-reverse;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        padding: 0.75rem;
        margin: 0;
    }

    .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-header .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
    }

    .modal-body {
        padding: 2rem;
        background-color: #ffffff;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #e0e0e0;
        color: #1a73e8;
        font-size: 1.1rem;
    }

    .form-control, .form-select {
        border: 2px solid #e0e0e0;
        padding: 0.75rem 1rem;
        color: #333333;
        font-size: 1.1rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1a73e8;
        box-shadow: 0 0 0 0.25rem rgba(26,115,232,.25);
    }

    .form-control::placeholder {
        color: #757575;
    }

    .btn-primary {
        background-color: #1a73e8;
        border-color: #1a73e8;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .btn-primary:hover {
        background-color: #1557b0;
        border-color: #1557b0;
    }

    .appointment-form label {
        color: #333333;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .alert {
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: none;
    }

    .alert-danger {
        background-color: #fdeded;
        color: #5f2120;
        border-left: 4px solid #ef5350;
    }

    .form-label {
        color: #333333 !important;
    }

    .form-select {
        background-position: left 0.75rem center !important;
        padding-left: 2.25rem !important;
        padding-right: 1rem !important;
    }

    .input-group .form-select {
        border-radius: 0 0.375rem 0.375rem 0;
    }

    .cart-sidebar {
        position: fixed;
        top: 0;
        right: -100%;
        width: 100%;
        height: 100vh;
        background: #fff;
        box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        z-index: 1050;
        transition: right 0.3s ease;
        overflow-y: auto;
    }

    @media (min-width: 768px) {
        .cart-sidebar {
            width: 400px;
        }
    }

    .cart-sidebar.active {
        right: 0;
    }

    body.cart-open {
        overflow: hidden;
    }

    .cart-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1040;
    }

    .cart-overlay.active {
        display: block;
    }

    .cart-header {
        padding: 1rem;
        background: #ffffff;
        border-bottom: 1px solid #e0e0e0;
        color: #333333;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cart-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .close-cart {
        background: none;
        border: none;
        color: #666666;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s ease;
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .close-cart:hover {
        color: #333333;
        background-color: #f5f5f5;
    }

    .close-cart i {
        font-size: 1.25rem;
    }

    .custom-color-section,
    .custom-size-section {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .custom-color-section input,
    .custom-size-section input {
        border: 2px solid #e0e0e0;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .custom-color-section input:focus,
    .custom-size-section input:focus {
        border-color: #6c5ce7;
        box-shadow: 0 0 0 0.25rem rgba(108, 92, 231, 0.25);
    }

    .custom-color-input,
    .custom-size-input {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
    }

    .form-check-label {
        cursor: pointer;
        user-select: none;
    }

    .form-check-input:checked + .form-check-label {
        color: #6c5ce7;
    }

    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let selectedColor = null;
        let selectedSize = null;

        function updateMainImage(src, thumbnail) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumbnail-wrapper').forEach(thumb => {
                thumb.classList.remove('active');
            });
            if (thumbnail) {
                thumbnail.classList.add('active');
            }
        }

        function selectColor(element) {
            if (!element.classList.contains('available')) return;

            // Uncheck custom color checkbox if exists
            const useCustomColorCheckbox = document.getElementById('useCustomColor');
            if (useCustomColorCheckbox) {
                useCustomColorCheckbox.checked = false;
                document.getElementById('customColorGroup').classList.add('d-none');
                document.getElementById('customColor').value = '';
            }

            // Remove active class from all colors
            document.querySelectorAll('.color-item').forEach(item => {
                item.classList.remove('active');
            });

            // Add active class to selected color
            element.classList.add('active');
            selectedColor = element.dataset.color;
        }

        function selectSize(element) {
            if (!element.classList.contains('available')) return;

            // Uncheck custom size checkbox if exists
            const useCustomSizeCheckbox = document.getElementById('useCustomSize');
            if (useCustomSizeCheckbox) {
                useCustomSizeCheckbox.checked = false;
                document.getElementById('customSizeGroup').classList.add('d-none');
                document.getElementById('customSize').value = '';
            }

            // Remove active class from all sizes
            document.querySelectorAll('.size-item').forEach(item => {
                item.classList.remove('active');
            });

            // Add active class to selected size
            element.classList.add('active');
            selectedSize = element.dataset.size;

            // If size is selected, uncheck needs appointment
            document.getElementById('needsAppointment').checked = false;
        }

        function updatePageQuantity(change) {
            const quantityInput = document.getElementById('quantity');
            let newQuantity = parseInt(quantityInput.value) + change;

            if (newQuantity >= 1 && newQuantity <= {{ $product->stock }}) {
                quantityInput.value = newQuantity;
            }
        }

        function showAppointmentModal(cartItemId) {
            document.getElementById('cart_item_id').value = cartItemId;
            const modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
            modal.show();
        }

        function toggleAddress() {
            const location = document.getElementById('location').value;
            const addressField = document.getElementById('addressField');

            if (location === 'client_location') {
                addressField.classList.remove('d-none');
                document.getElementById('address').setAttribute('required', 'required');
            } else {
                addressField.classList.add('d-none');
                document.getElementById('address').removeAttribute('required');
            }
        }

        function addToCart() {
            const needsAppointment = document.getElementById('needsAppointment').checked;
            const quantity = document.getElementById('quantity').value;
            const errorMessage = document.getElementById('errorMessage');

            // Get color value
            let colorValue = selectedColor;
            const customColorInput = document.getElementById('customColor');
            const useCustomColor = document.getElementById('useCustomColor');
            if (customColorInput && (!useCustomColor || useCustomColor.checked)) {
                const customColorValue = customColorInput.value.trim();
                if (customColorValue) {
                    colorValue = customColorValue;
                }
            }

            // Get size value
            let sizeValue = selectedSize;
            const customSizeInput = document.getElementById('customSize');
            const useCustomSize = document.getElementById('useCustomSize');
            if (customSizeInput && (!useCustomSize || useCustomSize.checked)) {
                const customSizeValue = customSizeInput.value.trim();
                if (customSizeValue) {
                    sizeValue = customSizeValue;
                }
            }

            // Validate selection only if sizes exist and no appointment is needed
            if (!needsAppointment && {{ $product->sizes->count() }} > 0 && !sizeValue) {
                showNotification('يرجى اختيار المقاس أو تحديد موعد لأخذ المقاسات', 'error');
                return;
            }

            // Hide any previous error
            errorMessage.classList.add('d-none');

            // Prepare data for API call
            const data = {
                product_id: {{ $product->id }},
                quantity: quantity,
                color: colorValue,
                size: sizeValue,
                needs_appointment: needsAppointment
            };

            // Show loading state
            const addToCartBtn = document.querySelector('.btn-primary[onclick="addToCart()"]');
            const originalBtnText = addToCartBtn.innerHTML;
            addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الإضافة...';
            addToCartBtn.disabled = true;

            // Make API call
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count and show success message
                    document.querySelector('.cart-count').textContent = data.cart_count;
                    showNotification(data.message, 'success');

                    // Update cart items
                    loadCartItems();

                    // Reset selections
                    selectedColor = null;
                    selectedSize = null;
                    document.querySelectorAll('.color-item, .size-item').forEach(item => {
                        item.classList.remove('active');
                    });

                    // Reset custom inputs if they exist
                    if (customColorInput) customColorInput.value = '';
                    if (customSizeInput) customSizeInput.value = '';

                    document.getElementById('quantity').value = 1;
                    document.getElementById('needsAppointment').checked = false;

                    // If appointment is needed, show modal
                    if (data.show_modal) {
                        document.getElementById('cart_item_id').value = data.cart_item_id;
                        const appointmentModal = new bootstrap.Modal(document.getElementById('appointmentModal'));
                        appointmentModal.show();
                    }
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ أثناء إضافة المنتج إلى السلة', 'error');
            })
            .finally(() => {
                // Reset button state
                addToCartBtn.innerHTML = originalBtnText;
                addToCartBtn.disabled = false;
            });
        }

        // Add notification system
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} notification-toast position-fixed top-0 start-50 translate-middle-x mt-3`;
            notification.style.zIndex = '9999';
            notification.innerHTML = message;
            document.body.appendChild(notification);

            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Update cart display function
        function updateCartDisplay(data) {
            const cartItems = document.getElementById('cartItems');
            const cartTotal = document.getElementById('cartTotal');
            const cartCount = document.querySelector('.cart-count');

            // Animate count change
            const currentCount = parseInt(cartCount.textContent);
            const newCount = data.count;
            if (currentCount !== newCount) {
                cartCount.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    cartCount.textContent = newCount;
                    cartCount.style.transform = 'scale(1)';
                }, 200);
            }

            cartTotal.textContent = data.total + ' ر.س';

            // Clear current items with fade out effect
            cartItems.style.opacity = '0';
            setTimeout(() => {
            cartItems.innerHTML = '';

            if (data.items.length === 0) {
                cartItems.innerHTML = `
                        <div class="cart-empty text-center p-4">
                            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                            <p class="mb-3">السلة فارغة</p>
                            <a href="/products" class="btn btn-primary">تصفح المنتجات</a>
                    </div>
                `;
                } else {
            data.items.forEach(item => {
                        const itemElement = document.createElement('div');
                        itemElement.className = 'cart-item';
                        itemElement.dataset.itemId = item.id;
                        itemElement.innerHTML = `
                            <div class="cart-item-inner p-3 border-bottom">
                                <button class="remove-btn btn btn-link text-danger" onclick="confirmDelete(${item.id})">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="d-flex gap-3">
                                    <img src="${item.image}" alt="${item.name}" class="cart-item-image" style="width: 80px; height: 80px; object-fit: cover;">
                                    <div class="cart-item-details flex-grow-1">
                                        <h5 class="cart-item-title mb-2">${item.name}</h5>
                                        <div class="cart-item-price mb-2">${item.price} ر.س</div>
                                        <div class="quantity-controls d-flex align-items-center gap-2">
                                            <button class="btn btn-sm btn-outline-secondary" onclick="updateCartQuantity(${item.id}, -1)">-</button>
                                            <input type="number" value="${item.quantity}" min="1"
                                        onchange="updateCartQuantity(${item.id}, 0, this.value)"
                                                class="form-control form-control-sm quantity-input" style="width: 60px;">
                                            <button class="btn btn-sm btn-outline-secondary" onclick="updateCartQuantity(${item.id}, 1)">+</button>
                                </div>
                                        <div class="cart-item-subtotal mt-2 text-primary">
                                    الإجمالي: ${item.subtotal} ر.س
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                        cartItems.appendChild(itemElement);
            });
                }
                // Fade in new items
                cartItems.style.opacity = '1';
            }, 300);
        }

        // Update cart quantity with animation
        function updateCartQuantity(itemId, change, newValue = null) {
            const quantityInput = document.querySelector(`[data-item-id="${itemId}"] .quantity-input`);
            const originalValue = parseInt(quantityInput.value);
            let quantity;

            if (newValue !== null) {
                quantity = parseInt(newValue);
            } else {
                quantity = originalValue + change;
            }

            if (quantity < 1) return;

            // Show loading state
            const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
            itemElement.style.opacity = '0.5';

            fetch(`/cart/items/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadCartItems();
                } else {
                    // Revert to original value if update failed
                    quantityInput.value = originalValue;
                    showNotification(data.message || 'Failed to update quantity', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert to original value
                quantityInput.value = originalValue;
                showNotification('حدث خطأ أثناء تحديث الكمية', 'error');
            })
            .finally(() => {
                itemElement.style.opacity = '1';
            });
        }

        // Remove cart item with animation
        function removeCartItem(itemId) {
            const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
            itemElement.style.transform = 'translateX(100%)';
            itemElement.style.opacity = '0';

            fetch(`/cart/items/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    setTimeout(() => {
                        loadCartItems();
                    }, 300);
                    showNotification(data.message, 'success');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ أثناء حذف المنتج', 'error');
                // Reset item state if delete failed
                itemElement.style.transform = 'none';
                itemElement.style.opacity = '1';
            });
        }

        // Initialize cart functionality
        document.addEventListener('DOMContentLoaded', function() {
            loadCartItems();

            // Setup event listeners
            document.getElementById('closeCart').addEventListener('click', closeCart);
            document.getElementById('cartToggle').addEventListener('click', openCart);

            // Custom Color Toggle
            const useCustomColorCheckbox = document.getElementById('useCustomColor');
            const customColorGroup = document.getElementById('customColorGroup');

            if (useCustomColorCheckbox) {
                useCustomColorCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        customColorGroup.classList.remove('d-none');
                        // Clear existing color selection
                        document.querySelectorAll('.color-item').forEach(item => {
                            item.classList.remove('active');
                        });
                        selectedColor = null;
                    } else {
                        customColorGroup.classList.add('d-none');
                        document.getElementById('customColor').value = '';
                    }
                });
            }

            // Custom Size Toggle
            const useCustomSizeCheckbox = document.getElementById('useCustomSize');
            const customSizeGroup = document.getElementById('customSizeGroup');

            if (useCustomSizeCheckbox) {
                useCustomSizeCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        customSizeGroup.classList.remove('d-none');
                        // Clear existing size selection
                        document.querySelectorAll('.size-item').forEach(item => {
                            item.classList.remove('active');
                        });
                        selectedSize = null;
                    } else {
                        customSizeGroup.classList.add('d-none');
                        document.getElementById('customSize').value = '';
                    }
                });
            }
        });

        // Cart Functions
        function openCart() {
            document.getElementById('cartSidebar').classList.add('active');
            document.querySelector('.cart-overlay').classList.add('active');
            document.body.classList.add('cart-open');
        }

        function closeCart() {
            document.getElementById('cartSidebar').classList.remove('active');
            document.querySelector('.cart-overlay').classList.remove('active');
            document.body.classList.remove('cart-open');
        }

        function loadCartItems() {
            fetch('/cart/items')
                .then(response => response.json())
                .then(data => {
                    updateCartDisplay(data);
                })
                .catch(error => console.error('Error:', error));
        }

        // Add event listener to needs appointment checkbox
        document.getElementById('needsAppointment').addEventListener('change', function(e) {
            if (e.target.checked) {
                // Clear size selection when appointment is needed
                document.querySelectorAll('.size-item').forEach(item => {
                    item.classList.remove('active');
                });
                selectedSize = null;
            }
        });

        // Add event listener to appointment form submission
        document.getElementById('appointmentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loading state
            const submitBtn = document.getElementById('submitAppointment');
            const spinner = submitBtn.querySelector('.spinner-border');
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');

            // Clear previous errors
            const errorDiv = document.getElementById('appointmentErrors');
            errorDiv.classList.add('d-none');
            errorDiv.textContent = '';

            const formData = new FormData(this);

            fetch('{{ route("appointments.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide modal
                    const appointmentModal = bootstrap.Modal.getInstance(document.getElementById('appointmentModal'));
                    appointmentModal.hide();

                    // Show success message
                    showNotification(data.message, 'success');

                    // Redirect to appointment details after 2 seconds
                    setTimeout(() => {
                        window.location.href = data.redirect_url || '/appointments';
                    }, 2000);
                } else {
                    // Show error message
                    errorDiv.textContent = data.message;
                    if (data.errors) {
                        const errorList = document.createElement('ul');
                        Object.values(data.errors).forEach(error => {
                            const li = document.createElement('li');
                            li.textContent = error[0];
                            errorList.appendChild(li);
                        });
                        errorDiv.appendChild(errorList);
                    }
                    errorDiv.classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorDiv.textContent = 'حدث خطأ أثناء حجز الموعد. الرجاء المحاولة مرة أخرى.';
                errorDiv.classList.remove('d-none');
            })
            .finally(() => {
                // Reset loading state
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
            });
        });

        // Initialize appointment date restrictions
        document.addEventListener('DOMContentLoaded', function() {
            const appointmentDate = document.getElementById('appointment_date');
            const today = new Date();
            const maxDate = new Date();
            maxDate.setDate(today.getDate() + 30); // Allow booking up to 30 days in advance

            appointmentDate.min = today.toISOString().split('T')[0];
            appointmentDate.max = maxDate.toISOString().split('T')[0];

            // Set default time range
            const appointmentTime = document.getElementById('appointment_time');
            appointmentTime.min = '09:00';
            appointmentTime.max = '21:00';
        });

        function showLoginPrompt(loginUrl) {
            const currentUrl = window.location.href;
            const modal = new bootstrap.Modal(document.getElementById('loginPromptModal'));
            document.getElementById('loginButton').href = `${loginUrl}?redirect=${encodeURIComponent(currentUrl)}`;
            modal.show();
        }
    </script>


</body>
</html>

