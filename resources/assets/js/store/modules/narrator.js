import Alert from '../../classes/alert';

/**
 * This is the ... module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {

    narrator: null,
    narrators: null,
    selected_narrator: null,

  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {

    storeNarrators(state, data){
      state.narrators = data;
    },

    addNarrator(state, data){
      state.narrators.push(data);
    },

    storeNarrator(state, narrator){
      state.selected_narrator = narrator;
    },

    removeNarrator(state){
      state.selected_narrator = null;
    }

  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {
    getAll: function({dispatch, commit, state}, data){

      if(state.narrators){
        return;
      }

      axios.get('/vue/narrators')
      .then( ({data}) => {
        commit('storeNarrators', data.narrators);
      })
      .catch( ({response}) => {

        Alert.dispatch(response.data.message, 'error');

      });
    },

    getNarratorById: function(id){
      axios.get('/vue/narrators/narrator/' + id)
      .then( ({data}) => {
        console.log(data);
      })
    },

    addNarrator: function({dispatch, commit}, data){

      axios.post('/vue/narrator/create', data)
      .then( ({data}) => {
        commit('addNarrator', data.narrator);
        dispatch('modal/hide', 'addNarrator', {root: true});

        Alert.dispatch('Successfully added new narrator', 'success');

      })
      .catch(({response}) => {

        Alert.dispatch(response.data.message, 'error');

      });

    },

    selectNarrator: function({commit}, data){
      commit('storeNarrator', data);
    },

    unselectNarrator: function({commit}){
      commit('removeNarrator');
    },


  },
}
