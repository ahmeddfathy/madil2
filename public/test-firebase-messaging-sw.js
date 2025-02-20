importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');

console.log('[Test Service Worker] Initializing...');

firebase.initializeApp({
    apiKey: "AIzaSyCBMLqzzmOAaDB2bkM2oja-0uOP5SclXAA",
    authDomain: "madil-notifications.firebaseapp.com",
    projectId: "madil-notifications",
    storageBucket: "madil-notifications.firebasestorage.app",
    messagingSenderId: "98732624533",
    appId: "1:98732624533:web:6335d91275f4640542699c"
});

console.log('[Test Service Worker] Firebase initialized');

const messaging = firebase.messaging();
console.log('[Test Service Worker] Messaging initialized');

messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[Test Service Worker] Received background message:', payload);

    const notificationOptions = {
        body: payload.notification.body,
        vibrate: [100, 50, 100],
        data: payload.data,
        actions: [
            {
                action: 'open',
                title: 'فتح الصفحة'
            }
        ],
        requireInteraction: true,
        dir: 'rtl',
        lang: 'ar'
    };

    console.log('[Test Service Worker] Showing notification with options:', notificationOptions);

    return self.registration.showNotification(
        payload.notification.title,
        notificationOptions
    );
});

self.addEventListener('notificationclick', function(event) {
    console.log('[Test Service Worker] Notification click received.');

    event.notification.close();

    if (event.action === 'open') {
        console.log('[Test Service Worker] Opening window');
        clients.openWindow('/test');
    }
});
