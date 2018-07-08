/**
 * We will first import all components and then finallay export them
 */

/**
 * These are the components used by the app
 */
import App from './app.vue';
import PageNotFound from './partials/PageNotFound.vue';
import Home from './home/index.vue';
import About from './about/index.vue';
import Profile from './users/profile.vue';
import Sections from './sections/index.vue';
import linked_sections from './related_hadiths/sections.vue';
import hadith_list from './sections/hadith_list.vue';
import linked_hadith_list from './related_hadiths/hadith_list.vue';
import search_button from './partials/search.vue';

//import Library from './library/index.vue';

// Libary components

import Books from './books/index.vue';
import book_list from './books/book_list.vue';
import Hadith from './hadith/index.vue';
import chain from './hadith/chain.vue';
import hadith_comments from './hadith_comments/index.vue';
import hadith_narrators from './hadith_narrators/index.vue';
import hadith_translations from './hadith_translations/index.vue';
import related_hadiths from './related_hadiths/index.vue';
import search_results from './search_results/index.vue';
import narrator_info from './narrators/narrator_info.vue';

//import addBook from './books/addBook.vue';

import addHadith from './modals/addHadith.vue';
import addHadithComment from './modals/addHadithComment.vue';
import addBook from './modals/addBook.vue';
import addLink from './modals/addLink.vue';
import addSection from './modals/addSection.vue';
import addAuthor from './modals/addAuthor.vue';
import addNarrator from './modals/addNarrator.vue';
import addCommentator from './modals/addCommentator.vue';
import addCommentary from './modals/addCommentary.vue';
import addBio from './modals/addBio.vue';
import addBioAuthor from './modals/addBioAuthor.vue';
import addBioBook from './modals/addBioBook.vue';
import addLanguage from './modals/addLanguage.vue';
import addTranslation from './modals/addTranslation.vue';
import linkHadith from './modals/linkHadith.vue';
import Register from './modals/registerForm.vue';
import Login from './modals/loginForm.vue';
import loading from './modals/loading.vue';
import navDrawer from './modals/navDrawer.vue';
import searchbar from './modals/search.vue';

//import LibraryHome from './library/home.vue';
// partial components

import nav from './partials/nav.vue';
import alert from './partials/alert.vue';
import modals from './partials/modals.vue';


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
   //Library,

   // Library components
   Books,
   book_list,
   Sections,
   linked_sections,
   hadith_list,
   linked_hadith_list,

   addBook,
   addSection,

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
   addLink,
   chain,
   hadith_comments,
   hadith_narrators,
   hadith_translations,
   related_hadiths,
   linkHadith,
   search_results,

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
 }
