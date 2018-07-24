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
