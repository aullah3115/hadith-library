/**
 * This is the ... module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {
    translations: null,
    translation: null,
  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {
    addTranslation(state, translation){
      if(!state.translations){
        state.translations = [];
      }
      state.comments.push(translation);
    },

    storeTranslations(state, translations){
      state.translations = translations;
    },

    removeTranslation(state){
      state.translation = null;
    },

    storeTranslation(state, translation){
      state.translation = translation;
    },
  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {

    addTranslation: function({dispatch, state, commit}, data){
      axios.post('/vue/hadith_translation/create', data)
      .then( ({data}) => {
        dispatch('modal/hide', 'addTranslation', {root: true});
        commit('addTranslation', data.translation);
      })
      .catch( (response) => {
        //TODO
      })
    },

    getTranslations: function({dispatch, state, commit}, hadith_id){

      axios.get('/vue/translations/for/hadith/' + hadith_id)
      .then( ({data}) => {
        commit('storeTranslations', data.translations);
      })
      .catch( (response) => {
        //TODO
      });
    },

    unselectTranslation: function({commit}){
      commit('removeTranslation');
    },

    selectTranslation: function({commit}, translation){
      commit('storeTranslation', translation);
    },
  },
}
