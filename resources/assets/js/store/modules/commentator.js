import Alert from '../../classes/alert';

/**
 * This is the Commentator module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {

    commentators: null,
  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {
    storeCommentators(state, data){
      state.commentators = data;
    },

    addCommentator(state, data){
      if(!state.commentators){
        state.commentators = [];
      }
      state.commentators.push(data);
    },
  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {
    getAll: function({dispatch, commit, state}, data){

      if(state.commentators){
        return;
      }

      axios.get('/vue/commentators')
      .then( ({data}) => {
        commit('storeCommentators', data.commentators);
      })
      .catch( ({response}) => {

        Alert.dispatch(response.data.message, 'error');

      });

    },

    addCommentator: function({dispatch, commit}, data){

      axios.post('/vue/commentator/create', data)
      .then( ({data}) => {
        commit('addCommentator', data.commentator);
        dispatch('modal/hide', 'addCommentator', {root: true});

        Alert.dispatch('Successfully added new commentator', 'success');

      })
      .catch(({response}) => {

        Alert.dispatch(response.data.message, 'error');

      });

    },

  },
}
