@extends('layouts.customer')
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Bara Lilth – ملابس أطفال عالية الجودة">
    <meta name="keywords" content="ملابس, أطفال, بر الليث, السعودية, متجر">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بر الليث | اتصل بنا</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        body {
    padding-top: 180px; /* Adjust this based on navbar height */
    padding-bottom:0 px;
}

@media (min-width: 992px) {
    body {
        padding-right: 290px; /* Adjust if your sidebar is fixed and has width */
    }
}
        body {
            font-family: 'Tajawal', sans-serif;
            padding-top: 180px;
            background-color: var(--light-bg);
        }
        
    </style>
</head>

<body style="font-family: 'Cairo', sans-serif;">


    <!-- Contact Section -->
    <section class="contact spad" style="padding: 60px 0;">
        <div class="container">
            <div class="row">

                <!-- معلومات التواصل -->
                <div class="col-lg-5">
                    <div class="contact__info" style="padding: 30px; background: white; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
                        <h2 style="font-size: 28px; font-weight: 700; color: #333;">معلومات التواصل</h2>
                        <p style="color: #777; margin-bottom: 20px;">يسعدنا تواصلكم معنا لأي استفسار أو ملاحظة.</p>

                        <div class="contact__details">
                            <div style="margin-bottom: 20px;">
                                <h4 style="font-size: 20px; color: #333; margin-bottom: 5px;">المملكة العربية السعودية</h4>
                                <p style="color: #777;">195 شارع باركر، كولورادو 801<br>+43 982-314-0958</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- نموذج التواصل -->
                <div class="col-lg-7">
                    <div class="contact__form" style="padding: 30px; background: white; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
                        <h2 style="font-size: 28px; font-weight: 700; color: #333; margin-bottom: 20px;">أرسل لنا رسالة</h2>
                        <form id="contactForm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div style="margin-bottom: 15px;">
                                        <input type="text" id="name" placeholder="الاسم الكامل" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div style="margin-bottom: 15px;">
                                        <input type="email" id="email" placeholder="البريد الإلكتروني" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div style="margin-bottom: 15px;">
                                        <textarea id="message" placeholder="رسالتك" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; height: 150px;"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="site-btn" style="width: 100%; background: green; color: white; padding: 12px; font-size: 18px; font-weight: bold; border: none; border-radius: 5px; cursor: pointer;">إرسال الرسالة</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer spad" style="background: #f8f8f8; padding: 40px 0;">
        <div class="container text-center">
            <p style="color: #777;">جميع الحقوق محفوظة &copy; 2025 بر الليث</p>
        </div>
    </footer>

    <!-- JS Files -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        // إرسال النموذج
        document.getElementById('contactForm').addEventListener('submit', function (e) {
            e.preventDefault();
            alert('تم إرسال رسالتك بنجاح! شكراً لتواصلك معنا.');
            this.reset();
        });
    </script>
</body>
</html>
