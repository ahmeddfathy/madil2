importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');

console.log('[Admin Service Worker] Initializing...');

// تكوين Firebase سيتم تمريره من الـ main application
self.addEventListener('message', function(event) {
    if (event.data && event.data.type === 'FIREBASE_CONFIG') {
        firebase.initializeApp(event.data.config);
        console.log('[Admin Service Worker] Firebase initialized');

        const messaging = firebase.messaging();
        console.log('[Admin Service Worker] Messaging initialized');

        messaging.setBackgroundMessageHandler(function(payload) {
            console.log('[Admin Service Worker] Received background message:', payload);

            const notificationTitle = payload.notification.title;
            const notificationOptions = {
                body: payload.notification.body,
                vibrate: [100, 50, 100],
                data: payload.data,
                actions: [
                    {
                        action: 'open_order',
                        title: 'عرض الطلب'
                    }
                ],
                requireInteraction: true,
                dir: 'rtl',
                lang: 'ar',
                tag: Date.now().toString()
            };

            console.log('[Admin Service Worker] Showing notification with options:', notificationOptions);

            return self.registration.showNotification(notificationTitle, notificationOptions);
        });
    }
});

self.addEventListener('notificationclick', function(event) {
    console.log('[Admin Service Worker] Notification click received.');

    event.notification.close();

    if (event.action === 'open_order') {
        console.log('[Admin Service Worker] Opening order page');
        const orderUrl = event.notification.data.link || '/admin/orders';
        clients.openWindow(orderUrl);
    }
});

self.addEventListener('push', function(event) {
    console.log('[Admin Service Worker] Push event received:', event);

    if (event.data) {
        const payload = event.data.json();
        console.log('[Admin Service Worker] Push event data:', payload);

        event.waitUntil(
            self.registration.showNotification(payload.notification.title, {
                body: payload.notification.body,
                vibrate: [100, 50, 100],
                data: payload.data,
                actions: [
                    {
                        action: 'open_order',
                        title: 'عرض الطلب'
                    }
                ],
                requireInteraction: true,
                dir: 'rtl',
                lang: 'ar',
                tag: Date.now().toString()
            })
        );
    }
});

self.addEventListener('install', function(event) {
    console.log('[Admin Service Worker] Service Worker installed');
    event.waitUntil(self.skipWaiting());
});

self.addEventListener('activate', function(event) {
    console.log('[Admin Service Worker] Service Worker activated');
    event.waitUntil(self.clients.claim());
});
