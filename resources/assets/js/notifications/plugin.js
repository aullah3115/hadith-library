import askNotificationPermission from './push_notifications';

const NotificationPlugin = {};
NotificationPlugin.install = function(Vue){
  Vue.prototype.$showNotification = function(){
    return askNotificationPermission();
  };

  Vue.prototype.$notificationsEnabled = function(){
    return Notification.permission === "granted" ? true : false;
  };
}

export default NotificationPlugin;