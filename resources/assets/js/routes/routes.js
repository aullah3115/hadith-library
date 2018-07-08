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

import authPerimeter from '../perimeters/auth';

/**
 * The following are the routes
 */

export default [

  {path: '/', component: Components.App, children: [

    {path: '', name: 'home', components: {main: Components.Home}, },

    {path: 'about', name: 'about', components: {main: Components.About}, },

    {path: 'profile',  name: 'profile', components: {main: Components.Profile},
    meta: {perimeter: authPerimeter, perimeterAction: 'auth'}, },

    {path: 'books', name: 'books', components: {main: Components.Books}, },

    {path: 'books/book/:book_id', name: 'openBook', components: {main: Components.Sections},
    props: {main: (route) =>( {book_id_prop: route.params.book_id, parent_id_prop: null, complete:true} ) }, },

    {path: 'sections/section/:parent_id', name: 'openSection',components: {main: Components.Sections},
    props: {main: (route) => ( {book_id_prop: null, parent_id_prop: route.params.parent_id, complete: true} ) }, },

    {path: 'hadiths/hadith/:hadith_id', name: 'hadith', components: {main: Components.Hadith},
    props: {main: true}, },

    {path: 'search/results', name: 'search_results', components: {main: Components.search_results},
    props: {main: true}, },

    {path: 'narrators/narrator/:narrator_id', name: 'narrator_info', components: {main: Components.narrator_info},
    props: {main: true}, },

    {path: '*', name: '404', components: {main: Components.PageNotFound}},


  //  {path: 'section/:parent_id/', name: 'sections', components: {main: Components.Sections},
    //props: {main: true,}, },

    //{path: 'hadith/:book_id/:parent_id/:hadith_id', name: 'hadith', components: {main: Components.Hadith},
    //props: {main: true}, },

  ]},


]
