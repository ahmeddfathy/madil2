<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>اختبار الإشعارات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            direction: rtl;
        }
        #logger {
            margin-top: 20px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 5px;
            max-height: 300px;
            overflow-y: auto;
        }
        button {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <button id="notificationBtn">اختبار الإشعار</button>
    <div id="logger"></div>

    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"></script>

    <script>
        function log(message, type = 'info') {
            const timestamp = new Date().toLocaleTimeString();
            const logMessage = `${timestamp}: ${message}`;
            console.log(logMessage);

            const logger = document.getElementById('logger');
            const color = type === 'error' ? 'red' : type === 'success' ? 'green' : 'black';
            logger.innerHTML += `<div style="color: ${color}">${logMessage}</div>`;
            logger.scrollTop = logger.scrollHeight;
        }

        try {
            firebase.initializeApp({
                apiKey: "AIzaSyCBMLqzzmOAaDB2bkM2oja-0uOP5SclXAA",
                authDomain: "madil-notifications.firebaseapp.com",
                projectId: "madil-notifications",
                storageBucket: "madil-notifications.firebasestorage.app",
                messagingSenderId: "98732624533",
                appId: "1:98732624533:web:6335d91275f4640542699c"
            });
            log('تم تهيئة Firebase بنجاح', 'success');
        } catch (error) {
            log('خطأ في تهيئة Firebase: ' + error.message, 'error');
        }

        const messaging = firebase.messaging();
        log('تم تهيئة خدمة الرسائل');

        async function requestPermissionAndToken() {
            try {
                log('جاري التحقق من دعم Service Worker...');
                if (!('serviceWorker' in navigator)) {
                    throw new Error('المتصفح لا يدعم Service Worker');
                }
                if (!('PushManager' in window)) {
                    throw new Error('المتصفح لا يدعم الإشعارات');
                }

                log('جاري طلب إذن الإشعارات...');
                const permission = await Notification.requestPermission();
                log('الإذن: ' + permission, permission === 'granted' ? 'success' : 'error');

                if (permission === 'granted') {
                    log('جاري تسجيل Service Worker...');
                    const registration = await navigator.serviceWorker.register('/test-firebase-messaging-sw.js');
                    log('تم تسجيل Service Worker بنجاح', 'success');

                    try {
                        log('جاري إعداد Service Worker للرسائل...');
                        messaging.useServiceWorker(registration);

                        log('جاري طلب رمز FCM...');
                        const currentToken = await messaging.getToken();

                        if (currentToken) {
                            log('تم الحصول على رمز FCM: ' + currentToken, 'success');
                            return currentToken;
                        } else {
                            log('لم يتم الحصول على رمز التسجيل', 'error');
                            return null;
                        }
                    } catch (tokenError) {
                        log('خطأ في الحصول على الرمز: ' + tokenError.message, 'error');
                        return null;
                    }
                }
            } catch (err) {
                log('خطأ في عملية الإذن/الرمز: ' + err.message, 'error');
                return null;
            }
        }

        messaging.onMessage((payload) => {
            log('تم استلام رسالة في المقدمة: ' + JSON.stringify(payload));

            try {
                log('محاولة عرض الإشعار مباشرة...');
                const notification = new Notification(payload.notification.title, {
                    body: payload.notification.body,
                    vibrate: [100, 50, 100],
                    requireInteraction: true,
                    dir: 'rtl',
                    lang: 'ar',
                    tag: 'test-notification'
                });

                notification.onclick = function(event) {
                    event.preventDefault();
                    window.focus();
                    notification.close();
                };

                log('تم عرض الإشعار مباشرة', 'success');
            } catch (error) {
                log('خطأ في عرض الإشعار المباشر: ' + error.message, 'error');

                if ('serviceWorker' in navigator && 'PushManager' in window) {
                    navigator.serviceWorker.ready.then(registration => {
                        return registration.showNotification(payload.notification.title, {
                            body: payload.notification.body,
                            vibrate: [100, 50, 100],
                            requireInteraction: true,
                            dir: 'rtl',
                            lang: 'ar',
                            tag: 'test-notification',
                            data: payload.data
                        });
                    }).then(() => {
                        log('تم عرض الإشعار عبر Service Worker', 'success');
                    }).catch(error => {
                        log('خطأ في عرض الإشعار عبر Service Worker: ' + error.message, 'error');
                    });
                }
            }
        });

        document.getElementById('notificationBtn').addEventListener('click', async () => {
            log('تم النقر على الزر، جاري بدء عملية الإشعار...');
            const token = await requestPermissionAndToken();
            if (token) {
                log('جاري إرسال طلب الإشعار إلى الخادم...');
                fetch('/api/test-notification', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ token: token })
                })
                .then(response => response.json())
                .then(data => {
                    log('رد الخادم: ' + JSON.stringify(data), data.success ? 'success' : 'error');
                })
                .catch(error => {
                    log('خطأ في إرسال الإشعار: ' + error.message, 'error');
                });
            } else {
                log('لا يوجد رمز متاح، لا يمكن إرسال الإشعار', 'error');
            }
        });
    </script>
</body>
</html>
