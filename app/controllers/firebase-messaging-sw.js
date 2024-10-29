importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase.js');
importScripts('https://www.gstatic.com/firebasejs/4.2.0/firebase-messaging.js');

// Initialize Firebase
var config = {
    apiKey: "AIzaSyBPHEXmp3_O1ISUyFDIPL_oz7NZ_TjARkE",
    authDomain: "aotour-mobile-driver.firebaseapp.com",
    databaseURL: "https://aotour-mobile-driver.firebaseio.com",
    projectId: "aotour-mobile-driver",
    storageBucket: "aotour-mobile-driver.appspot.com",
    messagingSenderId: "658667908035"
  };

firebase.initializeApp(config);

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();


messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
    icon: 'image_notifications.png'
  };

  return self.registration.showNotification(notificationTitle, notificationOptions);
});
