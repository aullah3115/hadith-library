let public_key = document.head.querySelector('meta[name="public_key"]');


/*
 function notificationsActive(){
  if (Notification.permission === "granted"){
    return true;
  }
  return false;
}
*/
//export let notificationsActive = Notification.permission === "granted"? true: false;

function askPermission() {
    return new Promise(function(resolve, reject) {
      const permissionResult = Notification.requestPermission(function(result) {
        resolve(result);
      });

      if (permissionResult) {
        permissionResult.then(resolve, reject);
      }
    })
    .then(function(permissionResult) {
      if (permissionResult !== 'granted') {
        return false;
        throw new Error('We weren\'t granted permission.');
        
      } else {
        return true;
      }
    });
  }

function urlBase64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');

  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}

function subscribeUserToPush(path, public_key) {
  return navigator.serviceWorker.register(path)
  .then(function(registration) {
    const subscribeOptions = {
      userVisibleOnly: true,
      applicationServerKey: urlBase64ToUint8Array(
        public_key
      )
    };

    return registration.pushManager.subscribe(subscribeOptions);
  })
  .then(function(pushSubscription) {
    console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
    return pushSubscription;
  });
}

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
        return new Promise(function(resolve, reject){
          askPermission()
          .then(function(granted){
          if(granted){
              return subscribeUserToPush('../sw.js', public_key.content);
          }
          })
          .then(function(subscription){
          console.log(subscription);
          sendSubscriptionToBackEnd(subscription)
          resolve();
          });

          
        })
         
      
      }
    
    }
}
