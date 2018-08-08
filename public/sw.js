importScripts('https://storage.googleapis.com/workbox-cdn/releases/3.2.0/workbox-sw.js');
//console.log('Hi');

if (workbox) {
  console.log(`Yay! Workbox is loaded 🎉`);

workbox.precaching.precacheAndRoute([

]);
} else {
  console.log(`Boo! Workbox didn't load 😬`);
}

workbox.routing.registerRoute(
  new RegExp('.*\.js'),
  workbox.strategies.cacheFirst({
    // Use a custom cache name
    cacheName: 'js-cache',
  })
);

workbox.routing.registerRoute(
  // Cache CSS files
  /.*\.css/,
  // Use cache but update in the background ASAP
  workbox.strategies.staleWhileRevalidate({
    // Use a custom cache name
    cacheName: 'css-cache',
  })
);

workbox.routing.registerRoute(
  new RegExp('/app.*'),
  workbox.strategies.cacheFirst({
    cacheName: 'app-cache',
  })
);

workbox.routing.registerRoute(
  new RegExp('/vue.*'),
  workbox.strategies.cacheFirst({
    cacheName: 'vue-api-cache',
  })
);

self.addEventListener('push', function(event) {

  var body;
  if (event.data) {
    body = event.data.text();
  } else {
    body = 'Push message no payload';
  }

  var options = {
    body: body,
    //icon: 'images/notification-flat.png',
    vibrate: [100, 50, 100],
    data: {
      dateOfArrival: Date.now(),
      primaryKey: 1
    },
    actions: [
      {action: 'explore', 
      title: 'Explore this new world',
        //icon: 'images/checkmark.png'
      },
      {action: 'close', 
      title: 'I don\'t want any of this',
        //icon: 'images/xmark.png'
      },
    ]
  };
  
  const promiseChain = self.registration.showNotification('Push Notification', options);

  event.waitUntil(promiseChain);
  if (event.data) {
    console.log('This push event has data: ', event.data.text());
  } else {
    console.log('This push event has no data.');
  }
});
