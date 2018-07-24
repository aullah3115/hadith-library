
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


import Vuex from 'vuex';
import Vuetify from 'vuetify';
import VueRouter from 'vue-router';
import VueKindergarten from 'vue-kindergarten';
import VueScrollTo from 'vue-scrollto';
import VueMq from 'vue-mq';
import VueI18n from 'vue-i18n';
import TextHighlight from 'vue-text-highlight';

require('./filters/index');

Vue.use(VueRouter);
Vue.use(Vuex);

Vue.use(VueScrollTo);
Vue.use(VueI18n);

Vue.use(VueMq, {
  breakpoints: {
    sm: 480,
    md: 800,
    lg: Infinity,
  }
});

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
