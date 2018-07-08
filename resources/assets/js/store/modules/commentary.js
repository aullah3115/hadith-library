import Alert from '../../classes/alert';
import Book from '../../classes/book';

/**
 * This is the Book module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {

    commentaries: null,
    commentary: null,
  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {

    storeCommentaries(state, data) {
      state.commentaries = data;
    },


    addCommentary(state, book) {
      if(!state.commentaries){
        state.commentaries =[];
      }
        state.commentaries.push(book);
    },

    storeCommentary(state, book){
      state.commentary = book;
    }

  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {

    getAll: function({dispatch, commit, state}, data) {

      if(state.commentaries){
        return;
      }


      //dispatch('modal/show', 'loading', {root: true});
      //dispatch('modal/setMessage', 'Loading...', {root: true});

      axios.get('/vue/commentaries')
      .then( ({data}) => {
        commit('storeCommentaries', data.commentaries);
        //dispatch('modal/hide', 'loading', {root: true});

      })
      .catch( ({response}) => {

        Alert.dispatch(response.data.message, 'error');
        //dispatch('modal/hide', 'loading', {root: true});

      });




    }, //End of action

    getForBook: function({state, dispatch, commit}, book_id){
      axios.get('/vue/commentaries/' + book_id)
      .then( ({data}) => {
        commit('storeCommentaries', data.commentaries);
        //dispatch('modal/hide', 'loading', {root: true});

      })
      .catch( ({response}) => {

        Alert.dispatch(response.data.message, 'error');
        //dispatch('modal/hide', 'loading', {root: true});

      });
    },


    addCommentary: function({dispatch, commit, state}, data) {

      axios.post('/vue/commentary/create', data)
      .then( ({data}) => {
        console.log(data.commentary);
        commit('addCommentary', data.commentary);

        dispatch('modal/hide', 'addCommentary', {root: true});

        Alert.dispatch('Commentary successfully added', 'success');

      })
      .catch((response) => {
        Alert.dispatch(response.data.message, 'error');

      });

    },

    storeCommentary: function({dispatch, commit, state}, data){
      var book = new Book(data);
      commit('storeCommentary', book);


    },

  /* getBookbyId: function({dispatch, commit, state}, book_id){
      if(state.books && state.books.id == book_id){
        //console.log('book exists');
        return;
      }
      axios.get('/vue/books/book/' + book_id)
      .then(function({data}){
        //console.log(data.book);
        dispatch('openBook', data.book);
      })
      .catch();
    },
*/


  },
}
