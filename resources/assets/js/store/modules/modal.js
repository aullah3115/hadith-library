/**
 * This is the Modal module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {
    modals: {
      navDrawer: false,
      loading: false,
      login: false,
      register: false,
      addBook: false,
      addCommentary: false,
      addCommentator: false,
      addSection: false,
      addHadith: false,
      addHadithComment: false,
      addNarrator: false,
      addAuthor: false,
      addLink: false,
      addBio: false,
      addBioAuthor: false,
      addBioBook: false,
      addLanguage: false,
      addTranslation: false,
      linkHadith: false,
      searchbar: false,
    },

    showModals: [],

    loadingMessage: '',

  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {

    show(state, modal){
      for(let modal in state.modals){
        state.modals[modal] = false;
      }

      state.showModals.unshift(modal);

      let display = state.showModals[0];

      state.modals[display] = true;
    },

    hide(state, modal){

      state.modals[modal] = false;
      let index = state.showModals.indexOf(modal);

      state.showModals.splice(index, 1);

      if(state.showModals.length){
        let display = state.showModals[0];
        state.modals[display] = true;
      }
      if(modal == 'loading'){
        state.loadingMessage = '';
      }

    },

    setMessage(state, message){
      state.loadingMessage = message;
    },

  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {

    show: function({commit}, modal){
      commit('show', modal);
    },

    hide: function({commit}, modal){
      commit('hide', modal);
    },

    setMessage: function({commit}, message){
      commit('setMessage', message);
    },



  },
}
