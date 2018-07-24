import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
/**
 * We will firstly import all modules. These will need to be registered
 * below.
 */

import admin from './modules/admin';
import user from './modules/user';
import book from './modules/book';
import commentary from './modules/commentary';
import alert from './modules/alert';
import author from './modules/author';
import section from './modules/section';
import hadith from './modules/hadith';
import modal from './modules/modal';
import narrator from './modules/narrator';
import commentator from './modules/commentator';
import hadith_comment from './modules/hadith_comment';
import hadith_translation from './modules/hadith_translation';
import bio_author from './modules/bio_author';
import bio_book from './modules/bio_book';
import bio from './modules/bio';


/*
 * This will import the root state, actions, getters, and mutations
 * from the partials folder.
 */

import state from  './partials/state';
import actions from './partials/actions';
import mutations from './partials/mutations';
import getters from './partials/getters';

/*
 *Here we will import the modules from the the modules folder.
 */


const store = new Vuex.Store(
  {

    modules: {

      admin,
      user,
      book,
      commentary,
      alert,
      author,
      section,
      hadith,
      modal,
      narrator,
      commentator,
      hadith_comment,
      hadith_translation,
      bio_author,
      bio_book,
      bio,

    },

    state,

    actions,

    mutations,

    getters
  }
)

export default store;
