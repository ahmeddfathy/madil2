@extends('layouts.customer')

@section('title', 'من نحن - بر الليث')

@section('content')

<head>
      
    <link rel="stylesheet" href="{{ asset('assets/kids-clothes/css2/style.css') }}" type="text/css">
    <style>
         body {
            font-family: 'Tajawal', sans-serif;
            padding-top: 10px;
            background-color: var(--light-bg);
        }
        </style>
</head>
<!-- Breadcrumb Section -->
<section class="breadcrumb-option py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text text-center">
                    <h4 class="mb-3">من نحن</h4>
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}">الرئيسية</a>
                        <span>من نحن</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-bold text-primary">تعرف على متجر بر الليث</h2>
            <p class="text-muted">نقدم لكم أفضل المنتجات للأطفال بجودة عالية وأسعار مناسبة</p>
        </div>
        
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="about-image rounded-3 overflow-hidden shadow">
                    <img src="{{ asset('assets/kids-clothes/img/about/clothes-wooden-table.jpg') }}" alt="عن متجر بر الليث" class="img-fluid w-100">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <h3 class="fw-bold text-primary position-relative pe-3">من نحن</h3>
                    <p class="text-muted">نحن متجر بر الليث، نعمل في مجال ملابس الأطفال منذ سنوات طويلة، ونسعى دائماً لتقديم الأفضل لعملائنا الكرام. نفتخر بكوننا أحد أبرز المتاجر المتخصصة في ملابس الأطفال في منطقة مكة المكرمة.</p>
                    
                    <h3 class="fw-bold text-primary position-relative pe-3 mt-4">رؤيتنا</h3>
                    <p class="text-muted">أن نكون الخيار الأول للأهل الذين يبحثون عن الجودة والأناقة لملابس أطفالهم، مع الحفاظ على الأسعار المناسبة التي تناسب جميع الفئات.</p>
                    
                    <div class="about-features mt-4">
                        <h3 class="fw-bold text-primary position-relative pe-3">لماذا تختارنا؟</h3>
                        <div class="feature-item d-flex align-items-start mb-3">
                            <div class="feature-icon text-primary ms-3 mt-1">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="feature-text">
                                <h4 class="fw-bold">جودة عالية</h4>
                                <p class="text-muted mb-0">نختار موادنا بعناية لضمان الراحة والمتانة لأطفالكم</p>
                            </div>
                        </div>
                        <div class="feature-item d-flex align-items-start mb-3">
                            <div class="feature-icon text-primary ms-3 mt-1">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="feature-text">
                                <h4 class="fw-bold">تصاميم عصرية</h4>
                                <p class="text-muted mb-0">أحدث صيحات الموضة للأطفال بألوان وتصاميم جذابة</p>
                            </div>
                        </div>
                        <div class="feature-item d-flex align-items-start mb-3">
                            <div class="feature-icon text-primary ms-3 mt-1">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="feature-text">
                                <h4 class="fw-bold">أسعار تنافسية</h4>
                                <p class="text-muted mb-0">نقدم أفضل الأسعار مع الحفاظ على الجودة العالية</p>
                            </div>
                        </div>
                        <div class="feature-item d-flex align-items-start mb-3">
                            <div class="feature-icon text-primary ms-3 mt-1">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="feature-text">
                                <h4 class="fw-bold">خدمة عملاء مميزة</h4>
                                <p class="text-muted mb-0">فريق خدمة العملاء لدينا جاهز لمساعدتك في أي وقت</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


  <!-- Footer Section Begin -->
  <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="#"><img src="{{ asset('assets/kids-clothes/img/logo.png') }}" width="100" height="150" alt=""></a>
                        </div>
                        <p>The customer is at the heart of our unique business model, which includes design.</p>
                        <a href="#"><img src="{{ asset('assets/kids-clothes/img/payment.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Clothing Store</a></li>
                            <li><a href="#">Trending Shoes</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Sale</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Payment Methods</a></li>
                            <li><a href="#">Delivary</a></li>
                            <li><a href="#">Return & Exchanges</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>NewLetter</h6>
                        <div class="footer__newslatter">
                            <p>Be the first to know about new arrivals, look books, sales & promos!</p>
                            <form action="#">
                                <input type="text" placeholder="Your email">
                                <button type="submit"><span class="icon_mail_alt"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->
@endsection