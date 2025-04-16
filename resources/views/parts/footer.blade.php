<!-- Footer
<footer class="bg-dark py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="logo-container">
                    <img src="{{ asset('assets/kids/img/logo.png') }}" alt="بر الليث Logo">
                </div>
                <p class="footer-description">العميل هو محور نموذج أعمالنا الفريد، والذي يشمل التصميم.</p>
                <div class="payment-methods">
                    <img src="{{ asset('assets/kids/img/payment.png') }}" alt="طرق الدفع">
                </div>
            </div>
            <div class="col-lg-3 mb-4 mb-lg-0">
                <h5>التسوق</h5>
                <ul class="footer-links">
                    <li><a href="#">متجر الملابس</a></li>
                    <li><a href="#">أحذية رائجة</a></li>
                    <li><a href="#">إكسسوارات</a></li>
                    <li><a href="#">تخفيضات</a></li>
                </ul>
            </div>
            <div class="col-lg-3 mb-4 mb-lg-0">
                <h5>خدمات</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('contact') }}">اتصل بنا</a></li>
                    <li><a href="#">طرق الدفع</a></li>
                    <li><a href="#">التوصيل</a></li>
                    <li><a href="#">الإرجاع والاستبدال</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5>النشرة البريدية</h5>
                <p>كن أول من يعرف عن وصول منتجات جديدة والعروض والتخفيضات!</p>
                <div class="newsletter-form">
                    <input type="email" placeholder="بريدك الإلكتروني">
                </div>
            </div>
        </div>
    </div>
</footer> -->


    <!-- Footer -->
    <footer class="glass-footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="footer-about">
              <h5>عن المصنع</h5>
              <p>نقدم ملابس أطفال عالية الجودة بتصاميم عصرية وخامات ممتازة بأفضل الأسعار</p>
              <div class="social-links">
                <a href="https://www.instagram.com/barallaith/?igsh=d2ZvaHZqM2VoMWsw#" class="social-link"><i class="fab fa-instagram"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="footer-links">
              <h5>روابط سريعة</h5>
              <ul>
                <li><a href="/">الرئيسية</a></li>
                <li><a href="/products">المنتجات</a></li>
                <li><a href="/about">من نحن</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="footer-contact">
              <h5>معلومات التواصل</h5>
              <div class="container">
                  <div class="contact-info-box mt-4 mb-5">
                      <h4>معلومات التواصل</h4>
                      <div class="contact-item">
                          <div class="contact-icon">
                              <i class="fas fa-phone-alt"></i>
                          </div>
                          <div class="contact-text" dir="ltr">
                              +966561667885
                          </div>
                      </div>
                      <div class="contact-item">
                          <div class="contact-icon">
                              <i class="fas fa-envelope"></i>
                          </div>
                          <div class="contact-text">
                              <a href="mailto:barallaith@outlook.sa">barallaith@outlook.sa</a>
                          </div>
                      </div>
                      <div class="contact-item">
                          <div class="contact-icon">
                              <i class="fas fa-map-marker-alt"></i>
                          </div>
                          <div class="contact-text">
                              محافظة الليث - مكة المكرمة
                          </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container">
          <p>جميع الحقوق محفوظة &copy; {{ date('Y') }} بر الليث</p>
        </div>
      </div>
    </footer>
