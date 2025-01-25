<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Madil</title>
    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>

<body>
    <!-- Main Content -->
    <div class="App">
        <div class="hero_area">
            <!-- Navbar -->
            <header class="header_section">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg custom_nav-container">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <span>Madil</span>
                        </a>

                        <button
                            class="navbar-toggler"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ url('/') }}">الرئيسية</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/#services') }}">خدماتنا</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/#about') }}">من نحن</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/#contact') }}">تواصل معنا</a>
                                </li>
                                @if (Route::has('login'))
                                @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                                </li>
                                @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Log in</a>
                                </li>
                                @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                                @endif
                                @endauth
                                @endif
                            </ul>
                        </div>
                    </nav>
                </div>
            </header>

            <!-- Hero Section -->
            <section class="slider_section">
                <div
                    id="customCarousel1"
                    class="carousel slide"
                    data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="img-box">
                                            <img
                                                src="https://th.bing.com/th/id/R.d72b7f0dcfe17ebeadb3f808a66ea531?rik=zc1M%2bgBTc1vJHw&pid=ImgRaw&r=0"
                                                alt="تفصيل وخياطة" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-box">
                                            <h1>أناقتك تبدأ من هنا</h1>
                                            <div class="col-lg-12">
                                                <div class="contact-logo" data-aos="fade-left">
                                                    <div class="logo-circle-container">
                                                        <div class="logo-big-circle">
                                                            <span class="logo-text">
                                                                <span class="logo-letter">M</span>
                                                                <span class="logo-name">Madil</span>
                                                            </span>
                                                            <p class="logo-subtitle">للتفصيل والخياطة</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>
                                                نقدم لكم أفضل خدمات التفصيل والخياطة للرجال والنساء
                                                بأحدث التصاميم العصرية وأجود أنواع الأقمشة
                                            </p>
                                            <div class="btn-box">
                                                <a href="#contact" class="btn1">احجز موعدك الآن</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ol class="carousel-indicators">
                        <li
                            data-bs-target="#customCarousel1"
                            data-bs-slide-to="0"
                            class="active"></li>
                        <li data-bs-target="#customCarousel1" data-bs-slide-to="1"></li>
                        <li data-bs-target="#customCarousel1" data-bs-slide-to="2"></li>
                    </ol>
                </div>
            </section>
        </div>

        <!-- Services Section -->
        <section class="service_section layout_padding" id="services">
            <div class="container">
                <div class="heading_container text-center mb-5">
                    <h2 class="main-title">الخدمات المُقدمة</h2>
                    <p class="subtitle">يقوم المشروع بتقديم كل من الخدمات التالية</p>
                    <div class="title-line mx-auto"></div>
                </div>

                <div class="row justify-content-center g-4">
                    <!-- خدمة تفصيل العباءات النسائية -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="content">
                                <div class="icon-container">
                                    <i class="fas fa-cut"></i>
                                </div>
                                <h3>تفصيل العباءات النسائية</h3>
                                <p class="para">
                                    نقدم خدمة تفصيل العباءات النسائية بأحدث التصاميم العصرية
                                    وأجود أنواع الأقمشة مع إمكانية التفصيل حسب الطلب
                                </p>
                                <a href="#contact" class="link">
                                    المزيد من التفاصيل
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- خدمة التفصيل والخياطة للرجال -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="content">
                                <div class="icon-container">
                                    <i class="fas fa-tshirt"></i>
                                </div>
                                <h3>التفصيل والخياطة للرجال</h3>
                                <p class="para">
                                    نقدم خدمات التفصيل والخياطة للرجال والتي تشمل:
                                    <br />- الثياب الرجالية المختلفة <br />- السديريات <br />-
                                    جلابيات النوم
                                </p>
                                <a href="#contact" class="link">
                                    المزيد من التفاصيل
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="about_section layout_padding" id="about">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="detail-box">
                            <div class="heading_container">
                                <span class="subtitle">تعرف علينا</span>
                                <h2 class="main-title">من نحن</h2>
                                <div class="title-line"></div>
                            </div>
                            <div class="about-content">
                                <p>
                                    نحن متخصصون في تقديم خدمات التفصيل والخياطة بأعلى مستويات
                                    الجودة. نمتلك خبرة تزيد عن 15 عاماً في مجال الخياطة
                                    والتفصيل، ونستخدم أحدث التقنيات وأجود أنواع الأقمشة لنضمن لك
                                    الحصول على قطع ملابس تناسب ذوقك وتليق بك.
                                </p>
                                <div class="btn-box">
                                    <a href="#services" class="read-more">
                                        <span>تعرف على خدماتنا</span>
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="img-box">
                            <div class="img-wrapper">
                                <img
                                    src="https://th.bing.com/th/id/R.23d79f8fd7d3e1aef2b932005a936cc3?rik=yIPf8uKsvuzKPQ&pid=ImgRaw&r=0"
                                    alt="خياطة وتفصيل"
                                    class="img-fluid" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact_section layout_padding" id="contact">
            <div class="container">
                <div class="row align-items-center justify-content-between g-5">
                    <div class="col-lg-6">
                        <div class="form_container glass-effect">
                            <div class="heading_container">
                                <span class="subtitle">تواصل معنا</span>
                                <h2>احجز موعدك الآن</h2>
                                <p class="section-description">
                                    يمكنك حجز موعد للقياس أو الاستفسار عن أي من خدماتنا
                                </p>
                            </div>

                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif

                            <form class="contact-form" action="{{ route('appointments.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-icon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input type="text"
                                            name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="الاسم بالكامل"
                                            value="{{ old('name') }}"
                                            required />
                                    </div>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-icon">
                                            <i class="fa fa-phone"></i>
                                        </span>
                                        <input type="tel"
                                            name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="رقم الجوال"
                                            value="{{ old('phone') }}"
                                            required />
                                    </div>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-icon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="date"
                                            name="appointment_date"
                                            class="form-control @error('appointment_date') is-invalid @enderror"
                                            value="{{ old('appointment_date') }}"
                                            min="{{ date('Y-m-d') }}"
                                            required />
                                    </div>
                                    @error('appointment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-icon">
                                            <i class="fa fa-list"></i>
                                        </span>
                                        <select name="service_type"
                                            class="form-control @error('service_type') is-invalid @enderror"
                                            required>
                                            <option value="">اختر نوع الخدمة</option>
                                            <option value="new_abaya" {{ old('service_type') == 'new_abaya' ? 'selected' : '' }}>
                                                تفصيل عباية جديدة
                                            </option>
                                            <option value="alteration" {{ old('service_type') == 'alteration' ? 'selected' : '' }}>
                                                تعديل عباية
                                            </option>
                                            <option value="repair" {{ old('service_type') == 'repair' ? 'selected' : '' }}>
                                                إصلاح عباية
                                            </option>
                                        </select>
                                    </div>
                                    @error('service_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-icon">
                                            <i class="fa fa-comment"></i>
                                        </span>
                                        <textarea name="notes"
                                            class="form-control @error('notes') is-invalid @enderror"
                                            placeholder="تفاصيل الطلب"
                                            rows="4">{{ old('notes') }}</textarea>
                                    </div>
                                    @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        إرسال الطلب <i class="fa fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Logo Column -->
                    <div class="col-lg-5">
                        <div class="contact-logo" data-aos="fade-left">
                            <div class="logo-circle-container">
                                <div class="logo-big-circle">
                                    <span class="logo-text">
                                        <span class="logo-letter">M</span>
                                        <span class="logo-name">Madil</span>
                                    </span>
                                    <p class="logo-subtitle">للتفصيل والخياطة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section class="products_section layout_padding" id="products">
            <div class="container">
                <div class="heading_container text-center mb-5">
                    <h2 class="main-title">منتجاتنا</h2>
                    <p class="subtitle">مجموعة مختارة من أحدث تصاميمنا</p>
                    <div class="title-line mx-auto"></div>
                </div>

                <div class="row justify-content-center g-4">
                    @foreach($products as $product)
                    <div class="col-md-4">
                        <div class="product-card">
                            <div class="imgBx">
                                <x-product-image
                                    :product="$product"
                                    size="full"
                                    class="w-100 h-100 object-cover" />
                            </div>
                            <div class="contentBx">
                                <h2>{{ $product->name }}</h2>
                                <div class="size">
                                    <h3>المقاس :</h3>
                                    <span>S</span>
                                    <span>M</span>
                                    <span>L</span>
                                    <span>XL</span>
                                </div>
                                <div class="color">
                                    <h3>اللون :</h3>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <div class="price">{{ number_format($product->price / 100, 0) }} ريال</div>
                                <a href="{{ route('products.show', $product) }}">اطلب الآن</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Footer -->
        <div class="footer_container">
            <section class="info_section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info_logo">
                                <h3>الخياط الماهر</h3>
                                <p>
                                    خبرة تزيد عن 15 عاماً في مجال التفصيل والخياطة نقدم لكم أفضل
                                    الخدمات بأعلى جودة
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info_links">
                                <h4>روابط سريعة</h4>
                                <ul>
                                    <li><a href="#home">الرئيسية</a></li>
                                    <li><a href="#services">خدماتنا</a></li>
                                    <li><a href="#about">من نحن</a></li>
                                    <li><a href="#contact">تواصل معنا</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info_contact">
                                <h4>معلومات التواصل</h4>
                                <div class="contact_link_box">
                                    <a href="">
                                        <i class="fa fa-map-marker"></i>
                                        <span>شارع الملك فهد، الرياض، السعودية</span>
                                    </a>
                                    <a href="">
                                        <i class="fa fa-phone"></i>
                                        <span>+966 50 123 4567</span>
                                    </a>
                                    <a href="">
                                        <i class="fa fa-envelope"></i>
                                        <span>info@tailor.com</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info_social">
                                <h4>تابعنا على</h4>
                                <div class="social_box">
                                    <a href="#"><i class="fab fa-facebook"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="footer_section">
                <div class="container">
                    <p>جميع الحقوق محفوظة &copy; 2024 الخياط الماهر</p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
