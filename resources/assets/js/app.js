
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

import messages from './language/messages';

const i18n = new VueI18n({
  locale: 'en',
  fallbackLocale: 'en',
  messages,
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 /**
  * I have decided to store components in a subdirectory and will import them
  * here.
  */




/**
 * Here we will initialize the store
 */

require('./channels/index');
import store from './store/index';

Vue.use(Vuetify, {rtl: store.state.rtl});

//const store = new Vuex.Store(Store);

/**
 * Next we will set up the router
 */

//import Routes from './routes/routes';

//const routes = Routes;

//const router = new VueRouter({mode: 'history', base: '/app/', routes,});


/**
 * Now we set up the vue acl
 */

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
