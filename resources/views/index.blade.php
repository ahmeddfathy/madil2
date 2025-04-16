<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @include('parts.head')
    <title>بر الليث - ملابس أطفال مميزة</title>

    <!-- Preload critical assets -->
    <link rel="preload" href="{{ asset('assets/kids/img/hero/hero-1.jpg') }}" as="image">
    <link rel="preload" href="{{ asset('assets/kids/css/common.css') }}" as="style">
    <link rel="preload" href="{{ asset('assets/kids/css/home.css') }}" as="style">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/kids/css/home.css') }}">
</head>
<body>
    @include('parts.navbar')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container-fluid p-0">
            <div class="position-relative">
                <img src="{{ asset('assets/kids/img/hero/hero-1.jpg') }}" class="img-fluid w-100" alt="تشكيلة شتاء للأطفال" width="1920" height="900">
                <div class="hero-content">
                    <span class="small-text">تشكيلة الشتاء</span>
                    <h1>تشكيلة خريف - شتاء<br>2030</h1>
                    <p>علامة تجارية متخصصة في صناعة الملابس الفاخرة. مصنوعة بحرفية عالية مع التزام لا يتزعزع بالجودة الاستثنائية.</p>
                    <a href="{{ route('shop') }}" class="btn btn-dark px-4 py-2">تسوق الآن</a>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Collections Section -->
    <section class="collections-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="collection-card position-relative">
                        <img src="{{ asset('assets/kids/img/banner/banner-1.jpg') }}" class="img-fluid" alt="تشكيلة الملابس" width="600" height="300" loading="lazy">
                        <div class="collection-content">
                            <h3>تشكيلة<br>ملابس 2025</h3>
                            <a href="{{ route('products.index') }}" class="shop-link">تسوق الآن</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="collection-card position-relative">
                                <img src="{{ asset('assets/kids/img/banner/banner-2.jpg') }}" class="img-fluid" alt="إكسسوارات" width="600" height="140" loading="lazy">
                                <div class="collection-content">
                                    <h3>إكسسوارات</h3>
                                    <a href="{{ route('products.index') }}" class="shop-link">تسوق الآن</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="collection-card position-relative">
                                <img src="{{ asset('assets/kids/img/banner/banner-3.jpg') }}" class="img-fluid" alt="مجموعة ملابس" width="600" height="140" loading="lazy">
                                <div class="collection-content">
                                    <h3>مجموعة ملابس<br>2025</h3>
                                    <a href="{{ route('products.index') }}" class="shop-link">تسوق الآن</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="categories-menu">
                        <h4 class="mb-4">ملابس رائجة</h4>
                        <ul class="list-unstyled">
                            <li><a href="#" class="active">تشكيلة الأحذية</a></li>
                            <li><a href="#">إكسسوارات</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="deal-box">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="sale-badge">
                                    <span>تخفيض</span>
                                    <h5>29.99 ريال</h5>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="deal-content">
                                    <span class="deal-label">عرض الأسبوع</span>
                                    <h3>حقيبة صدر سوداء متعددة الجيوب</h3>
                                    <div class="countdown-timer" id="countdown-timer">
                                        <div class="countdown-item">
                                            <span class="number">29</span>
                                            <span class="text">يوم</span>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="number">14</span>
                                            <span class="text">ساعة</span>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="number">00</span>
                                            <span class="text">دقيقة</span>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="number">25</span>
                                            <span class="text">ثانية</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('products.index') }}" class="btn btn-dark px-4 py-2 mt-3">تسوق الآن</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="featured-products-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <span class="section-badge">منتجات مميزة</span>
                <h2 class="section-title">منتجاتنا المميزة</h2>
                <p class="section-subtitle">اكتشف تشكيلاتنا من ملابس الأطفال الفاخرة</p>
            </div>

            <div class="featured-products-container">
                <div class="row g-4">
                    @foreach($featuredProducts as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image-wrapper">
                                <a href="{{ route('products.show', $product->slug) }}" class="product-link">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image" loading="lazy">
                                    @if($product->stock <= 0)
                                    <div class="out-of-stock-badge">نفذت الكمية</div>
                                    @endif
                                    @if($product->discount_percentage > 0)
                                    <div class="discount-badge">-{{ $product->discount_percentage }}%</div>
                                    @endif
                                </a>
                                <div class="product-actions">
                                    <a href="{{ route('products.show', $product->slug) }}" class="action-btn quickview-btn" title="عرض المنتج">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-category">{{ $product->category_name }}</div>
                                <h3 class="product-title">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                <div class="product-price">
                                    @if($product->min_price == $product->max_price)
                                        @if($product->original_price > $product->min_price)
                                            <span class="original-price">{{ number_format($product->original_price, 2) }} ريال</span>
                                        @endif
                                        <span class="current-price">{{ number_format($product->min_price, 2) }} ريال</span>
                                    @else
                                        @if($product->original_price > $product->min_price)
                                            <span class="original-price">{{ number_format($product->original_price, 2) }} ريال</span>
                                        @endif
                                        <span class="current-price">{{ number_format($product->min_price, 2) }} - {{ number_format($product->max_price, 2) }} ريال</span>
                                    @endif
                                </div>
                                <div class="product-colors">
                                    @if($product->allow_color_selection && $product->colors->isNotEmpty())
                                        <div class="color-options">
                                            @foreach($product->colors->take(4) as $color)
                                                <span class="color-option" data-color="{{ $color->color_code }}" title="{{ $color->name }}"></span>
                                            @endforeach
                                            @if($product->colors->count() > 4)
                                                <span class="color-option more-colors">+{{ $product->colors->count() - 4 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}" class="buy-now-btn">اشتري الآن</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="view-all-container text-center mt-5">
                <a href="{{ route('shop') }}" class="btn-view-all">عرض جميع المنتجات</a>
            </div>
        </div>
    </section>

    <!-- Instagram Section -->
    <section class="instagram-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="instagram-grid">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/kids/img/instagram/instagram-1.jpg') }}" class="img-fluid" alt="منشور انستغرام" width="300" height="180" loading="lazy">
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset('assets/kids/img/instagram/instagram-2.jpg') }}" class="img-fluid" alt="منشور انستغرام" width="300" height="180" loading="lazy">
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset('assets/kids/img/instagram/instagram-3.jpg') }}" class="img-fluid" alt="منشور انستغرام" width="300" height="180" loading="lazy">
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset('assets/kids/img/instagram/instagram-4.jpg') }}" class="img-fluid" alt="منشور انستغرام" width="300" height="180" loading="lazy">
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset('assets/kids/img/instagram/instagram-5.jpg') }}" class="img-fluid" alt="منشور انستغرام" width="300" height="180" loading="lazy">
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset('assets/kids/img/instagram/instagram-6.jpg') }}" class="img-fluid" alt="منشور انستغرام" width="300" height="180" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="instagram-content">
                        <h2>انستغرام</h2>
                        <p>تابعونا على انستغرام لمشاهدة أحدث تشكيلاتنا وعروضنا الحصرية من ملابس الأطفال المميزة.</p>
                        <h4 class="hashtag">#أزياء_الأطفال</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('parts.footer')

    <!-- Bootstrap JS - Load at end of body -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- Custom JS - deferred loading for performance -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Intersection Observer for lazy loading elements
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {threshold: 0.1});

        // Observe all sections except hero
        document.querySelectorAll('section:not(.hero-section)').forEach(section => {
            observer.observe(section);
        });
    });
    </script>

    <!-- Product Card Interactions -->
    <script src="{{ asset('assets/kids/js/products.js') }}" defer></script>
</body>
</html>
