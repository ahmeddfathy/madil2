<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>من نحن - Madil</title>
    <!-- Bootstrap CSS RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/customer/products.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/about.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg glass-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Madil" height="70">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">من نحن</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">المنتجات</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">الملف الشخصي</a>
                        </li>
                    @endauth
                </ul>
                <div class="nav-buttons">
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">تسجيل الخروج</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">تسجيل الدخول</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">إنشاء حساب</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content glass-effect">
                        <h1 class="display-4 mb-4">مرحباً بكم في Madil</h1>
                        <p class="lead mb-4">نقدم خدمات تفصيل وخياطة عالية الجودة للرجال والنساء في مدينة جدة</p>
                        <a href="#vision" class="btn btn-primary btn-lg">تعرف علينا</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <img src="https://th.bing.com/th/id/OIP.8a3oE0p9Dg0ZMHdihf7hJQHaE7?w=1400&h=933&rs=1&pid=ImgDetMain"
                             alt="خياطة وتفصيل"
                             class="img-fluid rounded-circle">
                        <div class="image-placeholder">
                            <i class="fas fa-scissors"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section id="vision" class="vision-mission-section">
        <div class="curved-top"></div>
        <div class="container">
            <div class="row g-5">
                <!-- Vision -->
                <div class="col-lg-6">
                    <div class="vision-card glass-effect">
                        <div class="content-wrapper">
                            <div class="icon-circle">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h2>رؤيتنا</h2>
                            <div class="vision-image">
                                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978" alt="رؤيتنا" class="img-fluid">
                            </div>
                            <p class="lead">أن نكون المحل الرائد في مجال تفصيل الملابس الرجالية والنسائية في مدينة جدة، وأن نتميز بجودة التصاميم والخامات.</p>
                            <ul class="vision-points">
                                <li>التميز في جودة التصاميم والخامات</li>
                                <li>تقديم تجربة متميزة للعملاء</li>
                                <li>الجمع بين الأصالة والابتكار</li>
                                <li>التوسع المستدام في مجال الأزياء</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Mission -->
                <div class="col-lg-6">
                    <div class="mission-card glass-effect">
                        <div class="content-wrapper">
                            <div class="icon-circle">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <h2>رسالتنا</h2>
                            <div class="mission-image">
                                <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e" alt="رسالتنا" class="img-fluid">
                            </div>
                            <p class="lead">تقديم خدمات تفصيل الملابس بمستوى عالٍ من الجودة والدقة في التصميم، مع التركيز على تلبية احتياجات مختلف الفئات.</p>
                            <ul class="mission-points">
                                <li>تقديم أعلى مستويات الجودة في التفصيل</li>
                                <li>تلبية احتياجات جميع الفئات العمرية</li>
                                <li>تقديم منتجات مبتكرة ومتميزة</li>
                                <li>تعزيز رضا العملاء باستمرار</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="curved-bottom"></div>
    </section>

    <!-- Timeline Section -->
    <section class="timeline-section">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>رحلتنا نحو النجاح</h2>
                <p class="lead">المراحل التي شكلت نمونا</p>
            </div>
            <div class="timeline">
                <div class="timeline-item left">
                    <div class="timeline-content glass-effect">
                        <div class="timeline-image">
                            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8"
                                 alt="افتتاح محل Madil 2020"
                                 class="img-fluid">
                        </div>
                        <div class="timeline-text">
                            <h3>2020</h3>
                            <p>افتتاح محل Madil للخياطة والتفصيل في جدة</p>
                        </div>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="timeline-content glass-effect">
                        <div class="timeline-image">
                            <img src="https://images.unsplash.com/photo-1589310243389-96a5483213a8"
                                 alt="توسيع الخدمات 2021"
                                 class="img-fluid">
                        </div>
                        <div class="timeline-text">
                            <h3>2021</h3>
                            <p>توسيع نطاق خدماتنا لتشمل التفصيل النسائي</p>
                        </div>
                    </div>
                </div>
                <div class="timeline-item left">
                    <div class="timeline-content glass-effect">
                        <div class="timeline-image">
                            <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f"
                                 alt="خدمات التعديل 2022"
                                 class="img-fluid">
                        </div>
                        <div class="timeline-text">
                            <h3>2022</h3>
                            <p>إضافة خدمات التعديل والإصلاح للملابس</p>
                        </div>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="timeline-content glass-effect">
                        <div class="timeline-image">
                            <img src="https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a"
                                 alt="المنصة الإلكترونية 2023"
                                 class="img-fluid">
                        </div>
                        <div class="timeline-text">
                            <h3>2023</h3>
                            <p>إطلاق منصتنا الإلكترونية لحجز المواعيد</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>أهدافنا</h2>
                <p class="lead">نسعى لتحقيق التميز في كل ما نقدمه</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="value-card glass-effect">
                        <div class="value-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3>الجودة العالية</h3>
                        <p>نقدم تصاميم وخدمات تفصيل متميزة تلبي أذواق واحتياجات العملاء في مدينة جدة</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card glass-effect">
                        <div class="value-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3>رضا العملاء</h3>
                        <p>نسعى لتعزيز رضا العملاء من خلال الاستماع لمتطلباتهم وتقديم خدمة متميزة</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card glass-effect">
                        <div class="value-icon">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </div>
                        <h3>التوسع المستمر</h3>
                        <p>نهدف للتوسع في تقديم منتجات مكملة مثل الأحذية والإكسسوارات لتعزيز تجربة التسوق</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="team-section">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>فريق العمل</h2>
                <p class="lead">نخبة من المتخصصين في مجال الخياطة والتفصيل</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="team-card glass-effect">
                        <div class="team-image">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a" alt="عضو الفريق" class="img-fluid">
                        </div>
                        <div class="team-info">
                            <h4>أحمد محمد</h4>
                            <p>المؤسس والمدير التنفيذي</p>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-card glass-effect">
                        <div class="team-image">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2" alt="عضو الفريق" class="img-fluid">
                        </div>
                        <div class="team-info">
                            <h4>سارة عبدالله</h4>
                            <p>مديرة قسم التصميم</p>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-card glass-effect">
                        <div class="team-image">
                            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7" alt="عضو الفريق" class="img-fluid">
                        </div>
                        <div class="team-info">
                            <h4>محمد علي</h4>
                            <p>رئيس قسم الخياطة الرجالية</p>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-card glass-effect">
                        <div class="team-image">
                            <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e" alt="عضو الفريق" class="img-fluid">
                        </div>
                        <div class="team-info">
                            <h4>نورة سعد</h4>
                            <p>مديرة خدمة العملاء</p>
                            <div class="team-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card glass-effect text-center">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">سنوات خبرة</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card glass-effect text-center">
                        <div class="stat-number">1000+</div>
                        <div class="stat-label">عميل سعيد</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card glass-effect text-center">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">تصميم مختلف</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card glass-effect text-center">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">دعم العملاء</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="glass-footer mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>عن Madil</h5>
                    <p>نقدم خدمات التفصيل والخياطة بأعلى جودة وأفضل الأسعار مع الالتزام بالمواعيد</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">سياسة الخصوصية</a></li>
                        <li><a href="#">الشروط والأحكام</a></li>
                        <li><a href="#">خدمات التفصيل</a></li>
                        <li><a href="#">تواصل معنا</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>تواصل معنا</h5>
                    <div class="contact-info">
                        <ul class="list-unstyled">
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-phone-alt ms-2"></i>
                                <span dir="ltr">054 315 4437</span>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-envelope ms-2"></i>
                                <a href="mailto:info@madil-sa.com" class="text-decoration-none">info@madil-sa.com</a>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt ms-2"></i>
                                <span>شارع الملك فهد، الرياض، المملكة العربية السعودية</span>
                            </li>
                        </ul>
                    </div>
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
                        <p class="mb-0">جميع الحقوق محفوظة &copy; {{ date('Y') }} Madil</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Scripts -->
    <script src="{{ asset('assets/js/about.js') }}"></script>
</body>
</html>
