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

    authors: null,
  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {
    storeAuthors(state, data){
      state.authors = data;
    },

    addAuthor(state, data){
      if(!state.authors){
        state.authors = [];
      }
      state.authors.push(data);
    },
  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {
    getAll: function({dispatch, commit, state}, data){

      if(state.authors){
        return;
      }
      axios.get('/vue/authors')
      .then( ({data}) => {

        commit('storeAuthors', data.authors);
      })
      .catch( ({response}) => {

        Alert.dispatch(response.data.message, 'error');

      });
    },

    addAuthor: function({dispatch, commit}, data){

      axios.post('/vue/author/create', data)
      .then( ({data}) => {
        commit('addAuthor', data.author);

        dispatch('modal/hide', 'addAuthor', {root: true});

        Alert.dispatch('Successfully added new author', 'success');

      })
      .catch(({response}) => {

        Alert.dispatch(response.data.message, 'error');


      });

    },


  },
}
