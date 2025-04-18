<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} - lens-soma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/products-show.css') }}?t={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/products.css') }}?t={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/custom-green-theme.css') }}?t={{ time() }}">

    <link rel="stylesheet" href="{{ asset('assets/kids/css/common.css') }}?t={{ time() }}">
</head>
<body>
    <!-- Fixed Buttons Group -->
    <div class="fixed-buttons-group">
        <button class="fixed-cart-btn" id="fixedCartBtn">
            <i class="fas fa-shopping-cart fa-lg"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">
                0
            </span>
        </button>
        @auth
        <a href="/dashboard" class="fixed-dashboard-btn">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </a>
        @endauth
    </div>

    @include('parts.navbar')

    <!-- Cart Overlay -->
    <div class="cart-overlay"></div>

    <!-- Cart Sidebar -->
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
                <li class="breadcrumb-item"><a href="/products?category={{ $product->category->slug }}">{{ $product->category->name }}</a></li>
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
                                <img src="{{ url('storage/' . $product->primary_image->image_path) }}"
                                    alt="{{ $product->name }}"
                                    class="main-product-image"
                                    id="mainImage">
                            </div>
                            @if($product->images->count() > 1)
                                <div class="image-thumbnails">
                                    @foreach($product->images as $image)
                                        <div class="thumbnail-wrapper {{ $image->is_primary ? 'active' : '' }}"
                                            onclick="updateMainImage('{{ url('storage/' . $image->image_path) }}', this)">
                                            <img src="{{ url('storage/' . $image->image_path) }}"
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

                    <div class="product-category d-flex flex-wrap gap-1 align-items-center mb-3">
                        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-decoration-none">
                            <span class="badge rounded-pill bg-primary">{{ $product->category->name }}</span>
                        </a>
                        @if($product->categories->isNotEmpty())
                            @foreach($product->categories as $additionalCategory)
                                @if($additionalCategory->id != $product->category_id)
                                    <a href="{{ route('products.index', ['category' => $additionalCategory->slug]) }}" class="text-decoration-none">
                                        <span class="badge rounded-pill bg-light text-dark border">{{ $additionalCategory->name }}</span>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    <!-- Available Coupons Section -->
                    @php
                        $availableCoupons = $product->getAvailableCoupons();
                    @endphp

                    @if($availableCoupons->isNotEmpty())
                        <div class="available-coupons mb-4">
                            <h5><i class="fas fa-tags"></i> كوبونات خصم متاحة</h5>
                            <div class="coupon-list">
                                @foreach($availableCoupons as $coupon)
                                    <div class="coupon-item">
                                        <div class="coupon-content">
                                            <div class="coupon-code">{{ $coupon->code }}</div>
                                            <div class="coupon-value">
                                                @if($coupon->type === 'percentage')
                                                    <span class="badge">خصم {{ $coupon->value }}%</span>
                                                @else
                                                    <span class="badge">خصم {{ $coupon->value }} ر.س</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="copy-btn-wrapper">
                                            <button class="copy-btn" data-code="{{ $coupon->code }}">
                                                <i class="fas fa-copy"></i> نسخ
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <small>
                                <i class="fas fa-info-circle"></i>
                                يمكنك استخدام هذه الكوبونات عند إتمام الطلب
                            </small>
                        </div>
                    @endif

                    <!-- Product Price -->
                    <div class="price-container">
                        <div class="product-price">
                            @if($product->min_price == $product->max_price)
                                <span class="amount">{{ number_format($product->min_price, 2) }}</span>
                                <span class="currency">ر.س</span>
                            @else
                                <span class="amount">{{ number_format($product->min_price, 2) }} - {{ number_format($product->max_price, 2) }}</span>
                                <span class="currency">ر.س</span>
                            @endif
                        </div>
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
                    @if(!empty($availableFeatures))
                    <div class="features-guide mb-4">
                        <div class="alert alert-info">
                            <h6 class="alert-heading mb-3">
                                <i class="fas fa-lightbulb me-2"></i>
                                ميزات الطلب المتاحة
                            </h6>
                            <ul class="features-list mb-0">
                                @foreach($availableFeatures as $feature)
                                    <li class="mb-2">
                                        <i class="fas fa-{{ $feature['icon'] }} me-2"></i>
                                        {{ $feature['text'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <!-- Colors Section -->
                    @if($product->allow_color_selection && $product->colors->isNotEmpty())
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
                                            <span class="color-preview" style="background-color: {{ $color->color }};"></span>
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
                        </div>
                    @endif

                    <!-- Custom Color Input -->
                    @if($product->allow_custom_color)
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

                    <!-- Available Sizes Section -->
                    @if($product->allow_size_selection && $product->sizes->isNotEmpty())
                        <div class="available-sizes mb-4">
                            <h5 class="fw-bold mb-3">المقاسات المتاحة</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($product->sizes as $size)
                                    @if($size->is_available)
                                    <button type="button"
                                        class="size-option btn"
                                        data-size="{{ $size->size }}"
                                        data-price="{{ $size->price }}"
                                        onclick="selectSize(this)">
                                        {{ $size->size }}
                                        @if($size->price != null)
                                            <span class="ms-2 badge bg-primary">{{ number_format($size->price, 2) }} ر.س</span>
                                        @endif
                                    </button>
                                    @else
                                    <button type="button" class="size-option btn disabled">
                                        {{ $size->size }} (غير متوفر)
                                    </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Quantity Pricing Section -->
                    @if($product->enable_quantity_pricing && $product->quantities->isNotEmpty())
                        <div class="quantity-pricing mb-4">
                            <h4>
                                <i class="fas fa-cubes"></i>
                                خيارات الكمية
                                <span class="badge bg-primary ms-2">مطلوب</span>
                            </h4>
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                يرجى اختيار أحد خيارات الكمية المتاحة
                            </div>
                            <div id="quantity-error-alert" class="alert alert-danger d-none">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>تنبيه:</strong> يجب عليك اختيار إحدى خيارات الكمية المتاحة قبل إضافة المنتج إلى السلة
                                <button type="button" class="btn-close float-end" onclick="this.parentElement.classList.add('d-none')"></button>
                            </div>
                            <div class="quantity-options">
                                @foreach($product->quantities as $quantity)
                                    <div class="quantity-option {{ $quantity->is_available ? 'available' : 'disabled' }}"
                                        onclick="{{ $quantity->is_available ? 'selectQuantityOption(this)' : 'return false' }}"
                                        data-quantity-id="{{ $quantity->id }}"
                                        data-quantity-value="{{ $quantity->quantity_value }}"
                                        data-price="{{ $quantity->price }}">
                                        <i class="fas fa-check"></i>
                                        <div class="quantity-details">
                                            <span class="quantity-value">{{ $quantity->quantity_value }} قطعة</span>
                                            <span class="quantity-price">{{ number_format($quantity->price, 2) }} ر.س</span>
                                            @if($quantity->description)
                                                <small class="quantity-description">{{ $quantity->description }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Custom Size Input -->
                    @if($product->allow_custom_size)
                        <div class="custom-size-input mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-ruler me-2"></i>
                                المقاس المطلوب
                            </h5>
                            <div class="input-group">
                                <input type="text" class="form-control" id="customSize" placeholder="اكتب المقاس المطلوب">
                            </div>
                        </div>
                    @endif

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
                        <button class="btn btn-primary btn-lg w-100 mb-4"
                                onclick="showLoginPrompt('{{ route('login') }}')"
                                type="button">
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

   @include('parts.footer')

    <!-- Login Prompt Modal -->
    <div class="modal fade" id="loginPromptModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تسجيل الدخول مطلوب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-user-lock fa-3x mb-3 text-primary"></i>
                    <p>يجب عليك تسجيل الدخول أولاً لتتمكن من طلب المنتج</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                        إلغاء
                    </button>
                    <a href="" class="btn btn-primary" id="loginButton">
                        تسجيل الدخول
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this hidden input for product ID -->
    <input type="hidden" id="product-id" value="{{ $product->id }}">

    <!-- Add this hidden input for original product price -->
    <input type="hidden" id="original-price" value="{{ $product->price }}">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/customer/products-show.js') }}?t={{ time() }}"></script>
    <script src="{{ asset('assets/js/customer/green-theme.js') }}?t={{ time() }}"></script>
</body>
</html>
