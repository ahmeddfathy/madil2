@extends('layouts.customer')



<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="متجر بر الليث - ملابس أطفال عالية الجودة، تصاميم عصرية، وخامات ممتازة">
    <meta name="keywords" content="ملابس أطفال, ملابس أطفال سعودية, ملابس أطفال مكة">
    <meta name="author" content="بر الليث">
    <meta name="theme-color" content="#ffffff">
    <title>بر الليث | خدماتنا</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Bootstrap RTL -->
   <!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
     -->
    <style>
        :root {
            --primary-color: #009245;
            --secondary-color: #007d3a;
            --light-bg: #f9f9f9;
        }
        body {
    padding-top: 130px; /* Adjust this based on navbar height */
    padding-bottom:0 px;
}

@media (min-width: 992px) {
    body {
        padding-right: 290px; /* Adjust if your sidebar is fixed and has width */
    }
}
        body {
            font-family: 'Tajawal', sans-serif;
            padding-top: 130px;
            background-color: var(--light-bg);
        }
        
        
        
        /* Services Section */
        .services {
            padding: 60px 0;
            background-color: var(--light-bg);
        }
        
        .services h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .services h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 80px;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        .service-box {
            background: white;
            padding: 30px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 90%;
            text-align: right;
            border-bottom: 4px solid transparent;
        }
        
        .service-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-bottom-color: var(--primary-color);
        }
        
        .service-box i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: inline-block;
        }
        
        .service-box h4 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }
        
        .service-box p {
            color: #555;
            line-height: 1.7;
        }
        
        /* Footer */
        .footer {
            background-color: #222;
            color: #fff;
            padding: 50px 0 20px;
        }
        
        .footer__about img {
            margin-bottom: 20px;
        }
        
        .footer__widget h6 {
            color: #fff;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .footer__widget ul li {
            margin-bottom: 10px;
        }
        
        .footer__widget ul li a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer__widget ul li a:hover {
            color: #fff;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .service-box {
            animation: fadeIn 0.5s ease forwards;
        }
        
        .service-box:nth-child(1) { animation-delay: 0.1s; }
        .service-box:nth-child(2) { animation-delay: 0.2s; }
        .service-box:nth-child(3) { animation-delay: 0.3s; }
        .service-box:nth-child(4) { animation-delay: 0.4s; }
        .service-box:nth-child(5) { animation-delay: 0.5s; }
        .service-box:nth-child(6) { animation-delay: 0.6s; }
        
        /* Responsive */
        @media (max-width: 767px) {
            .services h2 {
                font-size: 1.5rem;
            }
            
            .service-box {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <h2>الخدمات التي نقدمها</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="service-box">
                        <i class="fas fa-tshirt"></i>
                        <h4>ملابس أطفال مخصصة</h4>
                        <p>نصمم ونصنع ملابس أطفال أنيقة ومريحة باستخدام أفضل أنواع الأقمشة ذات الجودة العالية.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box">
                        <i class="fas fa-leaf"></i>
                        <h4>أقمشة صديقة للبيئة</h4>
                        <p>نحرص على استخدام مواد عضوية وآمنة للأطفال في جميع عمليات التصنيع لدينا.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box">
                        <i class="fas fa-truck"></i>
                        <h4>توصيل سريع وآمن</h4>
                        <p>نوفر خدمة توصيل سريعة وآمنة لضمان وصول ملابس أطفالكم في الوقت المطلوب.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box">
                        <i class="fas fa-hands-helping"></i>
                        <h4>تصنيع أخلاقي</h4>
                        <p>نلتزم بممارسات عمل عادلة ونحرص على السلامة والجودة في مصنعنا.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box">
                        <i class="fas fa-boxes"></i>
                        <h4>طلبات الجملة</h4>
                        <p>نقدم عروضًا مميزة للطلبات بالجملة، مثالية للمتاجر ومنظمي الفعاليات.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-box">
                        <i class="fas fa-headset"></i>
                        <h4>دعم فني على مدار الساعة</h4>
                        <p>فريق الدعم لدينا متاح 24/7 لمساعدتكم في أي استفسارات أو مشكلات.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="#"><img src="/assets/images/logo.png" alt="بر الليث"width="120"></a>
                            
                        </div>
                        <p>متخصصون في تصميم وتصنيع ملابس الأطفال بأعلى معايير الجودة والأناقة.</p>
                        <div class="social-links mt-3">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-snapchat"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer__widget">
                        <h6>روابط سريعة</h6>
                        <ul>
                            <li><a href="/">الرئيسية</a></li>
                            <li><a href="/services">خدماتنا</a></li>
                            <li><a href="/products">المنتجات</a></li>
                            <li><a href="/about">من نحن</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer__widget">
                        <h6>خدمة العملاء</h6>
                        <ul>
                            <li><a href="/contact">اتصل بنا</a></li>
                            <li><a href="#">طرق الدفع</a></li>
                            <li><a href="#">الشحن والتوصيل</a></li>
                            <li><a href="#">الإرجاع والاستبدال</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer__widget">
                        <h6>النشرة البريدية</h6>
                        <p>كن أول من يعرف عن أحدث المنتجات والعروض الخاصة</p>
                        <form class="footer__newslatter">
                            <input type="text" placeholder="بريدك الإلكتروني">
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="footer__copyright text-center mt-4">
                <p>جميع الحقوق محفوظة &copy; <script>document.write(new Date().getFullYear())</script> بر الليث</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Simple animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const serviceBoxes = document.querySelectorAll('.service-box');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            serviceBoxes.forEach(box => {
                box.style.opacity = '0';
                box.style.transform = 'translateY(20px)';
                box.style.transition = 'all 0.5s ease';
                observer.observe(box);
            });
        });
    </script>
</body>
</html>