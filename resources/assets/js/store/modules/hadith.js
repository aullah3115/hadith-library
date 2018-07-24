import Alert from '../../classes/alert';

/**
 * This is the Hadith module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {
    hadiths: null, //move to sections module
    linked_hadiths: null, // move to related hadith module
    hadith: null,
    linked_hadith: null, // move to related hadith module
    related_hadith: null, // move to related hadith module
    related_hadiths: null, // move to related hadith module
    suggested_hadith: null,
    suggested_hadiths: null,
    chain: null,
    tab: "0",
    panel: null,
    search_results: null,
  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {
    storeHadiths(state, hadiths){
      state.hadiths = hadiths;
    },

    storeLinkedHadiths(state, hadiths){
      state.linked_hadiths = hadiths;
    },

    storeHadith(state, hadith){
      state.hadith = hadith;
    },

    storeLinkedHadith(state, hadith){
      state.linked_hadith = hadith;
    },

    storeChain(state, chain){
      state.chain = chain;
    },

    addHadith(state, hadith){
      state.hadiths.push(hadith);
    },

    addLink(state, data){
      state.chain.push(data[0]);
    },

    select_tab(state, tab){
      state.tab = tab;
    },

    select_panel(state, panel_no){
      state.panel = panel_no;
    },

    unselectLinkedHadith(state){
      state.linked_hadith = null;
    },

    addLinkedHadith(state, linked_hadith){
      if(!state.linked_hadiths){
        state.linked_hadiths = [];
      }

      state.linked_hadiths.push(linked_hadith);
    },

    storeRelatedHadiths(state, related_hadiths){
        state.related_hadiths = related_hadiths;
    },

    storeSuggestedHadiths(state, suggested_hadiths){
        state.suggested_hadiths = suggested_hadiths;
    },

    storeSearchResults(state, results){
      state.search_results = results;
    },

    selectRelatedHadith(state, hadith){
      state.related_hadith = hadith;
    },

    unselectRelatedHadith(state){
      state.related_hadith = null;
    },

    selectSuggestedHadith(state, hadith){
      state.suggested_hadith = hadith;
    },

    unselectSuggestedHadith(state){
      state.suggested_hadith = null;
    },

  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {

    getHadiths: function({commit, dispatch, state}, parent_id){
      if(!parent_id){
        return;
      }


      axios.get('/vue/hadith/in/section/' + parent_id)
      .then( ({data}) => {

          commit('storeHadiths', data.hadiths);
          return;

      })
      .catch();
    },

    getLinkedHadiths: function({commit, dispatch, state}, parent_id){
      if(!parent_id){
        return;
      }

      //console.log(data);
      axios.get('/vue/hadith/in/section/' + parent_id)
      .then( ({data}) => {

          commit('storeLinkedHadiths', data.hadiths);
          return;
      })
      .catch();
    },

    getHadith: function({commit, dispatch, state}, hadith_id){


      axios.get('/vue/hadiths/hadith/' + hadith_id)
      .then( ({data}) => {

          commit('storeHadith', data.hadith);
          return;

      })
      .catch( (response) =>{
        //TODO
      });

    },

    getLinkedHadith: function({commit, dispatch, state}, hadith_id){

      axios.get('/vue/hadiths/hadith/' + hadith_id)
      .then( ({data}) => {
        commit('storeLinkedHadith', data.hadith);

      })
      .catch( (response) =>{
        //TODO
      });

    },

    getChain: function({commit, dispatch, state}, hadith_id){

      axios.get('/vue/chain/for/hadith/' + hadith_id)
      .then( ({data}) => {
        commit('storeChain', data.chain);
      })
      .catch( (response) => {
        //TODO
      });
    },

    addHadith: function({commit, dispatch, state}, data){

      axios.post('/vue/hadith/create', data)
      .then( ({data}) => {
        commit('addHadith', data.hadith);
        dispatch('modal/hide', 'addHadith', {root: true});
        Alert.dispatch('Successfully added new hadith', 'success')
      })
      .catch( (response) => {
        //TODO
      });
    },

    editHadith: function({commit, dispatch, state}, data){
      axios.post('/vue/hadith/edit', data)
      .then( ({data}) => {
        commit('storeHadith', data.hadith);
        dispatch('modal/hide', 'editHadith', {root: true});
      })
    },

    addLink: function({commit, dispatch, state}, data){

      axios.post('/vue/addLink/to/hadith/', data)
      .then( ({data}) => {
        commit('addLink', data.link);
        dispatch('modal/hide', 'addLink', {root: true});
        Alert.dispatch('Successfully added a new link', 'success');

      })
      .catch( (response) => {
        //TODO
      })
    },

    linkHadith: function({commit, dispatch, state}, data){
      axios.post('/vue/hadith/link/with/hadith', data)
      .then( ({data}) => {
        commit('addLinkedHadith', data.linked_hadith);
      })
    },

    unselectLinkedHadith: function({commit, dispatch, state}){
      commit('unselectLinkedHadith');
    },

    getRelatedHadiths: function({commit, state, dispatch}, hadith_id){
      axios.get('/vue/related/hadith/for/hadith/' + hadith_id)
      .then( ({data}) => {
        commit('storeRelatedHadiths', data.linked_hadiths);
      })
    },

    getSuggestedHadiths: function({commit, state, dispatch}, hadith_id){
      axios.get('/vue/suggested/hadith/for/hadith/' + hadith_id)
      .then( ({data}) => {
        commit('storeSuggestedHadiths', data.suggested_hadiths);
      })
    },

    selectRelatedHadith: function({commit}, id){
      axios.get('/vue/hadiths/hadith/' + id)
      .then( ({data}) => {
        commit('selectRelatedHadith', data.hadith);
      })

    },

    unselectRelatedHadith: function({commit}){
      commit('unselectRelatedHadith');
    },

    selectSuggestedHadith: function({commit}, id){
      axios.get('/vue/hadiths/hadith/' + id)
      .then( ({data}) => {
        commit('selectSuggestedHadith', data.hadith);
      })

    },

    unselectSuggestedHadith: function({commit}){
      commit('unselectSuggestedHadith');
    },



  },
}
