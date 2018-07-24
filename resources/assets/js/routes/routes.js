/**
 * Imort the Vuex store
 */
import store from '../store/index';


/**
 * These are the components used by the app
 */
import Components from '../components/index';

/*
import Home from '../components/home/index.vue';
import Login from '../components/login/index.vue';
import Register from '../components/register/index.vue';
import About from '../components/about/index.vue';
import Library from '../components/library/index.vue';


/**
 * These are the components used by Laravel passport.
 */


import PassportClients from '../components/passport/Clients.vue';
import PassportAuthorizedClients from '../components/passport/AuthorizedClients.vue';
import PassportPersonalAccessToken from '../components/passport/PersonalAccessTokens.vue';

// perimeters

import authPerimeter from '@/acl/perimeters/auth';

/**
 * The following are the routes
 */

export default [

  {path: '/', component: Components.App, children: [

      {path: '', name: 'home', components: {main: Components.Home}, },

      {path: 'about', name: 'about', components: {main: Components.About}, },

      {path: 'profile',  name: 'profile', components: {main: Components.Profile},
      meta: {perimeter: authPerimeter, perimeterAction: 'auth'}, },

      {path: 'settings',  name: 'settings', components: {main: Components.Settings},
      meta: {perimeter: authPerimeter, perimeterAction: 'auth'}, },

  ],},

  {path: '/library', component: Components.App, children: [

    {path: '', name: 'books', components: {main: Components.Books}, },

    {path: 'books/book/:book_id(\\d+)', name: 'openBook', components: {main: Components.Sections},
    props: {main: (route) =>( {book_id: route.params.book_id, parent_id: null, } ) }, },

    {path: 'sections/section/:parent_id(\\d+)', name: 'openSection',components: {main: Components.Sections},
    props: {main: (route) => ( {book_id: null, parent_id: route.params.parent_id,} ) }, },

    {path: 'hadiths/hadith/:hadith_id(\\d+)', name: 'hadith', components: {main: Components.Hadith},
    props: {main: true}, },

    {path: 'search/results', name: 'search_results', components: {main: Components.search_results},
    props: {main: true}, },

    {path: 'narrators/narrator/:narrator_id(\\d+)', name: 'narrator', components: {main: Components.narrator_info},
    props: {main: true}, },

    {path: '*', name: '404', components: {main: Components.PageNotFound}},


  //  {path: 'section/:parent_id/', name: 'sections', components: {main: Components.Sections},
    //props: {main: true,}, },

    //{path: 'hadith/:book_id/:parent_id/:hadith_id', name: 'hadith', components: {main: Components.Hadith},
    //props: {main: true}, },

  ]},

  {path: '/super_admin', component: Components.super_admin_app, children: [

    {path: '', name: 'super-admin-home', components: {main: Components.super_admin_home}, 
    meta: {perimeter: authPerimeter, perimeterAction: 'superAdmin', } },

    {path: '*', name: 'admin-404', components: {main: Components.PageNotFound}},


  ]},

  


]
