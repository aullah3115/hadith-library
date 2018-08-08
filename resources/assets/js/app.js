
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//import {askNotificationPermission, notificationsActive} from './push_notifications';
//import {notificationsActive} from './push_notifications';


window.Vue = require('vue');
/*
const NotificationPlugin = {};
NotificationPlugin.install = function(Vue){
  Vue.prototype.$showNotification = function(){
    askNotificationPermission();
  };

  Vue.prototype.$notificationsActive = function(){
    return notificationsActive;
  };
}
*/

import Vuex from 'vuex';
import Vuetify from 'vuetify';
import VueRouter from 'vue-router';
import VueKindergarten from 'vue-kindergarten';
import VueScrollTo from 'vue-scrollto';
import VueMq from 'vue-mq';
import VueI18n from 'vue-i18n';
import TextHighlight from 'vue-text-highlight';
//import VueEcho from 'vue-echo-laravel';
import NotificationPlugin from './notifications/plugin';

require('./filters/index');

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(NotificationPlugin);
Vue.use(VueScrollTo);
Vue.use(VueI18n);

Vue.use(VueMq, {
  breakpoints: {
    sm: 480,
    md: 800,
    lg: Infinity,
  }
});

/*
Vue.use(VueEcho, {
  broadcaster: 'socket.io',
  host: window.location.hostname + ':6001',
});
*/
Vue.component('text-highlight', TextHighlight);

//require('./channels/index'); TODO required for websockets
import store from './store/index';

import messages from './language/messages';

//const locale = store.state.locale;

const i18n = new VueI18n({
  locale: 'en',
  fallbackLocale: 'en',
  messages,
});

Vue.use(Vuetify, {
  theme: {
    primary: store.state.theme.primary,
    secondary: store.state.theme.secondary,
    admin:store.state.theme.admin,
  },
  rtl: false,
})


 Vue.use(VueKindergarten, {child: (store) => {

     return store.state.user.user;
   }
 });

import router from './routes/router';

require('./components/registerComponents');

const app = new Vue({
    router,
    store,
    el: '#vue-app',
    i18n,
});
