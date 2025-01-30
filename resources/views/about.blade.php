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
            <a class="navbar-brand" href="{{ route('home') }}">
                Madil
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
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary position-relative me-2">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ Cart::count() }}
                            </span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">تسجيل الخروج</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">تسجيل الدخول</a>
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
                        <h1 class="display-4 mb-4">Our Journey</h1>
                        <p class="lead mb-4">Discover the story behind Modern Store, where innovation meets elegance in every product we offer.</p>
                        <a href="#team" class="btn btn-primary btn-lg">Meet Our Team</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image glass-effect">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c" alt="Team" class="img-fluid rounded-circle">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section class="vision-mission-section">
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
                            <h2>Our Vision</h2>
                            <p class="lead">To revolutionize the digital shopping experience by creating the most innovative and user-friendly e-commerce platform that sets new standards in the industry.</p>
                            <div class="vision-image">
                                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500" alt="Vision" class="img-fluid">
                            </div>
                            <ul class="vision-points">
                                <li><i class="fas fa-check-circle"></i> Leading Innovation in E-commerce</li>
                                <li><i class="fas fa-check-circle"></i> Global Market Expansion</li>
                                <li><i class="fas fa-check-circle"></i> Customer-Centric Approach</li>
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
                            <h2>Our Mission</h2>
                            <p class="lead">To provide exceptional value to our customers through high-quality products, outstanding service, and innovative shopping solutions.</p>
                            <div class="mission-image">
                                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500" alt="Mission" class="img-fluid">
                            </div>
                            <ul class="mission-points">
                                <li><i class="fas fa-star"></i> Excellence in Service</li>
                                <li><i class="fas fa-star"></i> Product Quality Assurance</li>
                                <li><i class="fas fa-star"></i> Customer Satisfaction</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="curved-bottom"></div>
    </section>

    <!-- Achievement Timeline Section -->
    <section class="timeline-section">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>Our Journey to Success</h2>
                <p class="lead">Milestones that shaped our growth</p>
            </div>
            <div class="timeline">
                <div class="timeline-item left">
                    <div class="timeline-content glass-effect">
                        <div class="timeline-image">
                            <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=500" alt="2020">
                        </div>
                        <h3>2020</h3>
                        <p>Launch of Modern Store with innovative e-commerce solutions</p>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="timeline-content glass-effect">
                        <div class="timeline-image">
                            <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=500" alt="2021">
                        </div>
                        <h3>2021</h3>
                        <p>Expanded to international markets with global shipping</p>
                    </div>
                </div>
                <div class="timeline-item left">
                    <div class="timeline-content glass-effect">
                        <div class="timeline-image">
                            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500" alt="2022">
                        </div>
                        <h3>2022</h3>
                        <p>Achieved 1 million happy customers worldwide</p>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="timeline-content glass-effect">
                        <div class="timeline-image">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500" alt="2023">
                        </div>
                        <h3>2023</h3>
                        <p>Launched innovative mobile app and AI-powered recommendations</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Awards Section -->
    <section class="awards-section">
        <div class="curved-top-alt"></div>
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>Our Achievements</h2>
                <p class="lead">Recognition of our excellence</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="award-card glass-effect">
                        <div class="award-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h4>Best E-commerce Platform</h4>
                        <p>2023 Digital Innovation Awards</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="award-card glass-effect">
                        <div class="award-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <h4>Customer Service Excellence</h4>
                        <p>2023 Retail Awards</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="award-card glass-effect">
                        <div class="award-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4>Best Mobile Experience</h4>
                        <p>2023 Mobile Excellence Awards</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="award-card glass-effect">
                        <div class="award-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4>Innovation in Retail</h4>
                        <p>2023 Tech Innovation Awards</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="curved-bottom-alt"></div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>Our Core Values</h2>
                <p class="lead">The principles that guide everything we do</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="value-card glass-effect">
                        <div class="value-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3>Innovation</h3>
                        <p>We constantly push boundaries to bring you the latest and most innovative products.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card glass-effect">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Quality</h3>
                        <p>Every product in our store meets the highest standards of quality and craftsmanship.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card glass-effect">
                        <div class="value-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Community</h3>
                        <p>We believe in building lasting relationships with our customers and community.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="team-section">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>Meet Our Team</h2>
                <p class="lead">The passionate individuals behind Modern Store</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="team-card glass-effect">
                        <div class="team-image">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a" alt="Team Member" class="img-fluid">
                        </div>
                        <div class="team-info">
                            <h4>John Doe</h4>
                            <p>Founder & CEO</p>
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
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2" alt="Team Member" class="img-fluid">
                        </div>
                        <div class="team-info">
                            <h4>Sarah Johnson</h4>
                            <p>Creative Director</p>
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
                            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7" alt="Team Member" class="img-fluid">
                        </div>
                        <div class="team-info">
                            <h4>Mike Wilson</h4>
                            <p>Product Manager</p>
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
                            <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e" alt="Team Member" class="img-fluid">
                        </div>
                        <div class="team-info">
                            <h4>Emily Chen</h4>
                            <p>Customer Success</p>
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
                        <div class="stat-number">5K+</div>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card glass-effect text-center">
                        <div class="stat-number">1K+</div>
                        <div class="stat-label">Products</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card glass-effect text-center">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Brands</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card glass-effect text-center">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support</div>
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
                    <p>متجرك المفضل للتسوق الإلكتروني، نقدم أفضل المنتجات بأسعار تنافسية مع خدمة عملاء متميزة.</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('privacy') }}">سياسة الخصوصية</a></li>
                        <li><a href="{{ route('terms') }}">الشروط والأحكام</a></li>
                        <li><a href="{{ route('shipping') }}">معلومات الشحن</a></li>
                        <li><a href="{{ route('faq') }}">الأسئلة الشائعة</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>تواصل معنا</h5>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-pinterest"></i></a>
                    </div>
                    <div class="newsletter mt-3">
                        <h6>اشترك في نشرتنا البريدية</h6>
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="input-group">
                            @csrf
                            <input type="email" name="email" class="form-control" placeholder="أدخل بريدك الإلكتروني" required>
                            <button type="submit" class="btn btn-primary">اشتراك</button>
                        </form>
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
