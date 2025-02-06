<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>المتجر الحديث | الرئيسية</title>
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/customer/products.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/index.css') }}">
  </head>
  <body>
    <!-- Navbar -->

<!-- Navbar -->
<nav class="navbar navbar-expand-lg glass-navbar sticky-top">
  <div class="container">
      <a class="navbar-brand" href="#">
       Madil
      </a>
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
                  <a class="nav-link" href="/products">المنتجات</a>
              </li>



          </ul>
          <div class="nav-buttons">
              @auth
                  <a href="{{ route('dashboard') }}" class="btn btn-primary">لوحة التحكم</a>
              @else
                  <a href="/login" class="btn btn-outline-primary me-2">تسجيل الدخول</a>
                  <a href="/register" class="btn btn-primary">إنشاء حساب</a>
              @endauth
          </div>
      </div>
  </div>
</nav>


    <!-- Hero Section -->
    <section class="hero-section">
      <div class="wave-top"></div>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content">
              <h1 class="hero-title">أناقتك تبدأ من هنا</h1>
              <p class="hero-text">اكتشف أحدث التصاميم العصرية وأجود أنواع الأقمشة مع خدمة التفصيل المتميزة</p>
              <div class="hero-buttons">
                <a href="#" class="btn btn-primary">اطلب الآن</a>
                <a href="#" class="btn btn-outline-primary">تعرف علينا</a>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="hero-image">
              <img
                src="https://th.bing.com/th/id/OIP.1yt_Dc_hfr6ts_gIpm6lMQHaJi?rs=1&pid=ImgDetMain"
                alt="تفصيل وخياطة"
                class="img-fluid"
              />
              <div class="floating-card">
                <div class="card-icon">
                  <i class="fas fa-star"></i>
                </div>
                <div class="card-content">
                  <h4>خدمة متميزة</h4>
                  <p>أكثر من 15 عام من الخبرة</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Services Section -->
    <section class="services-section">
      <div class="wave-top"></div>
      <div class="container">
        <div class="section-header text-center">
          <span class="section-subtitle">خدماتنا</span>
          <h2 class="section-title">ماذا نقدم لكم</h2>
          <div class="title-line"></div>
        </div>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="service-card">
              <div class="card-icon">
                <i class="fas fa-cut"></i>
              </div>
              <img src="https://th.bing.com/th/id/OIP.D7nA3n_V4NUqMLEVWF1M5QHaF8?rs=1&pid=ImgDetMain" alt="تفصيل وخياطة رجالي" class="img-fluid mb-3">
              <h3>تفصيل وخياطة رجالي</h3>
              <p>الثياب الرجالية المختلفة والسديريات وجلابيات النوم</p>
              <a href="#" class="card-link">اكتشف المزيد <i class="fas fa-arrow-left"></i></a>
            </div>
          </div>
          <div class="col-md-4">
            <div class="service-card">
              <div class="card-icon">
                <i class="fas fa-tshirt"></i>
              </div>
              <img src="https://th.bing.com/th/id/OIP.1yt_Dc_hfr6ts_gIpm6lMQHaJi?rs=1&pid=ImgDetMain" alt="تفصيل نسائي" class="img-fluid mb-3">
              <h3>تفصيل نسائي</h3>
              <p>تفصيل العبايات النسائية بأحدث التصاميم العصرية</p>
              <a href="#" class="card-link">اكتشف المزيد <i class="fas fa-arrow-left"></i></a>
            </div>
          </div>
          <div class="col-md-4">
            <div class="service-card">
              <div class="card-icon">
                <i class="fas fa-ruler"></i>
              </div>
<img src="https://th.bing.com/th/id/OIP.8DI5HCPocmh1DLXBecDzLwHaNj?rs=1&pid=ImgDetMain" alt="تعديلات وإصلاحات" class="img-fluid mb-3    ">              <h3>تعديلات وإصلاحات</h3>
              <p>خدمات التعديل والإصلاح لجميع أنواع الملابس</p>
              <a href="#" class="card-link">اكتشف المزيد <i class="fas fa-arrow-left"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="wave-bottom"></div>
    </section>
    <!-- Features Section -->
    <section class="features-section">
      <div class="wave-top"></div>
      <div class="container">
        <div class="row g-4">
          <div class="col-md-3">
            <div class="feature-card">
              <div class="feature-icon">
                <i class="fas fa-clock"></i>
              </div>
              <h4>سرعة في التنفيذ</h4>
              <p>نلتزم بالمواعيد المحددة مع جودة عالية في التنفيذ</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="feature-card">
              <div class="feature-icon">
                <i class="fas fa-medal"></i>
              </div>
              <h4>جودة عالية</h4>
              <p>نستخدم أفضل الأقمشة والخامات المستوردة</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="feature-card">
              <div class="feature-icon">
                <i class="fas fa-hand-holding-usd"></i>
              </div>
              <h4>أسعار منافسة</h4>
              <p>أسعار مناسبة مع خطط دفع مرنة وعروض مستمرة</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="feature-card">
              <div class="feature-icon">
                <i class="fas fa-headset"></i>
              </div>
              <h4>دعم متواصل</h4>
              <p>خدمة عملاء على مدار الساعة لتلبية احتياجاتكم</p>
            </div>
          </div>
        </div>
      </div>
      <div class="wave-bottom"></div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
      <div class="wave-top"></div>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="contact-content">
              <h2 class="section-title">تواصل معنا</h2>
              <p>نحن هنا لمساعدتك والإجابة على جميع استفساراتك</p>
              <div class="contact-info">
                <div class="info-item">
                  <i class="fas fa-map-marker-alt"></i>
                  <div class="info-content">
                    <h5>العنوان</h5>
                    <p>شارع الملك فهد، الرياض، المملكة العربية السعودية</p>
                  </div>
                </div>
                <div class="info-item">
                  <i class="fas fa-phone-alt"></i>
                  <div class="info-content">
                    <h5>اتصل بنا</h5>
                    <p>+966 50 123 4567</p>
                  </div>
                </div>
                <div class="info-item">
                  <i class="fas fa-envelope"></i>
                  <div class="info-content">
                    <h5>البريد الإلكتروني</h5>
                    <p>info@madil.com</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="contact-form">
              @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
              @endif
              <form method="POST" action="{{ route('contact.send') }}" class="contact-form-inner">
                @csrf
                <div class="form-group">
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                         placeholder="الاسم الكامل" required value="{{ old('name') }}" />
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                         placeholder="البريد الإلكتروني" required value="{{ old('email') }}" />
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                         placeholder="رقم الجوال" required value="{{ old('phone') }}" />
                  @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                            rows="4" placeholder="رسالتك" required>{{ old('message') }}</textarea>
                  @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">
                  <i class="fas fa-paper-plane me-2"></i>
                  إرسال الرسالة
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="glass-footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="footer-about">
              <h5>عن المتجر</h5>
              <p>نقدم خدمات التفصيل والخياطة بأعلى جودة وأفضل الأسعار مع الالتزام بالمواعيد</p>
              <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-pinterest"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="footer-links">
              <h5>روابط سريعة</h5>
              <ul>
                <li><a href="#">الرئيسية</a></li>
                <li><a href="#">خدماتنا</a></li>
                <li><a href="#">المنتجات</a></li>
                <li><a href="#">تواصل معنا</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="newsletter">
              <h6>اشترك في نشرتنا البريدية</h6>
              <div class="input-group">
                <input type="email" placeholder="البريد الإلكتروني" />
                <button class="btn">اشتراك</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container">
          <p>جميع الحقوق محفوظة &copy; 2024 المتجر الحديث</p>
        </div>
      </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
  </body>
</html>
