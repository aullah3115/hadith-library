
window._ = require('lodash');
window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from 'laravel-echo';
//window.io = require('socket.io-client');
require('./channels/index');

if (typeof io !== 'undefined') {
  window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
  });
}

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
/*require('./push_notifications');

function sendSubscriptionToBackEnd(subscription) {
 

 // console.log(subscriptionObject);
  axios.post('/vue/save-subscription', subscription)
  .then( (data) => {
    console.log(data);
  })

}

export default function askNotificationPermission(){
  if ("Notification" in window) {
    //console.log("This browser does not support desktop notification");
    if (Notification.permission === "granted") {
      // If it's okay let's create a notification
      var notification = new Notification("Hi there!");
      
    } else {
      askPermission()
      .then(function(granted){
        if(granted){
          return subscribeUserToPush('../sw.js', public_key.content);
        }
      })
      .then(function(subscription){
        console.log(subscription);
        sendSubscriptionToBackEnd(subscription)
      });
    
    }
    
  }
}
*/
// Let's check whether notification permissions have alredy been granted

  //getNotificationPermission();


window.addEventListener('beforeinstallprompt', (e) => {
  // Prevent Chrome 67 and earlier from automatically showing the prompt
  alert('Hi');
  console.log('PROMT');
  /*e.preventDefault();
  // Stash the event so it can be triggered later.
  deferredPrompt = e;
  let response = confirm('Add to Homescreen');
  if(response){
    deferredPrompt.promt();
    deferredPrompt.userChoice
      .then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
          console.log('User accepted the A2HS prompt');
        } else {
          console.log('User dismissed the A2HS prompt');
        }
        deferredPrompt = null;
      });
  }*/
 
});


window.diff = require('diff');
//import Echo from 'laravel-echo';