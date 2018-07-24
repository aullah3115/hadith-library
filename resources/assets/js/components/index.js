/**
 * We will first import all components and then finallay export them
 */

/**
 * These are the components used by the app
 */
import App from './app.vue';
import PageNotFound from './partials/PageNotFound.vue';
import Home from './general-components/home/index.vue';
import About from './general-components/about/index.vue';
import Settings from './general-components/settings/index.vue';
import Profile from './users/profile.vue';

import Sections from './library-components/sections/index.vue';
import linked_sections from './library-components/related_hadiths/sections.vue';
import hadith_list from './library-components/sections/hadith_list.vue';
import linked_hadith_list from './library-components/related_hadiths/related_hadiths.vue';
import suggested_hadith from './library-components/related_hadiths/suggested_hadiths.vue';

import search_button from './partials/search.vue';
import bottom_nav from './partials/bottom_nav.vue';
import footer from './partials/footer.vue';
//import Library from './library/index.vue';

// Admin components
import super_admin_app from './super-admin-components/app.vue';
import super_admin_home from './super-admin-components/home.vue';
import super_admin_nav from './super-admin-components/partials/nav.vue';

// Admin Modals
import addRole from './super-admin-components/modals/addRole.vue';
import addPermission from './super-admin-components/modals/addPermission.vue';
// Libary components

import Books from './library-components/books/index.vue';
import book_list from './library-components/books/book_list.vue';
import Hadith from './library-components/hadith/index.vue';
import chain from './library-components/hadith/chain.vue';
import hadith_comments from './library-components/hadith_comments/index.vue';
import hadith_narrators from './library-components/hadith_narrators/index.vue';
import hadith_translations from './library-components/hadith_translations/index.vue';
import related_hadiths from './library-components/related_hadiths/index.vue';
import search_results from './library-components/search_results/index.vue';
import narrator_info from './library-components/narrators/narrator_info.vue';

//import addBook from './books/addBook.vue';

import addHadith from './modals/add/addHadith.vue';
import editHadith from './modals/edit/editHadith.vue';
import addHadithComment from './modals/add/addHadithComment.vue';
import addBook from './modals/add/addBook.vue';
import editBook from './modals/edit/editBook.vue';
import addLink from './modals/add/addLink.vue';
import addSection from './modals/add/addSection.vue';
import editSection from './modals/edit/editSection.vue';
import addAuthor from './modals/add/addAuthor.vue';
import addNarrator from './modals/add/addNarrator.vue';
import addCommentator from './modals/add/addCommentator.vue';
import addCommentary from './modals/add/addCommentary.vue';
import addBio from './modals/add/addBio.vue';
import addBioAuthor from './modals/add/addBioAuthor.vue';
import addBioBook from './modals/add/addBioBook.vue';
import addLanguage from './modals/add/addLanguage.vue';
import addTranslation from './modals/add/addTranslation.vue';
import linkHadith from './modals/add/linkHadith.vue';
import Register from './modals/registerForm.vue';
import Login from './modals/loginForm.vue';
import loading from './modals/loading.vue';
import navDrawer from './modals/navDrawer.vue';
import searchbar from './modals/search.vue';
import displayNarrations from './modals/displayNarrations.vue';
import compare from './modals/compare.vue';

//import LibraryHome from './library/home.vue';
// partial components

import nav from './partials/nav.vue';
import alert from './partials/alert.vue';
import modals from './partials/modals.vue';

// widjets

import paginator from './widjets/paginate.vue';


/**
 * These are the components used by Laravel passport.
 */


import PassportClients from './passport/Clients.vue';
import PassportAuthorizedClients from './passport/AuthorizedClients.vue';
import PassportPersonalAccessToken from './passport/PersonalAccessTokens.vue';

/**
 * We will now export all components
 */

 export default {
   App,
   PageNotFound,
   Home,
   About,
   Settings,
   //Library,
  
  // Admin components
   super_admin_app,
   super_admin_home,
   super_admin_nav,

   // Admin Modals
   addRole,
   addPermission,

   // Library components
   Books,
   book_list,
   Sections,
   linked_sections,
   hadith_list,
   linked_hadith_list,
   suggested_hadith,

   addBook,
   editBook,
   addSection,
   editSection,

   addAuthor,
   addNarrator,
   addHadithComment,
   addCommentator,
   addCommentary,

   addBio,
   addBioAuthor,
   addBioBook,

   addLanguage,
   addTranslation,

   Hadith,
   addHadith,
   editHadith,
   addLink,
   chain,
   hadith_comments,
   hadith_narrators,
   hadith_translations,
   related_hadiths,
   linkHadith,
   search_results,
   displayNarrations,
   compare,

   narrator_info,

   Profile,
   //LibraryHome,

   // partials
   nav,
   Login,
   Register,
   alert,
   modals,
   loading,
   navDrawer,
   search_button,
   searchbar,
   bottom_nav,
   footer,

   //widjets
   paginator,
   
 }
