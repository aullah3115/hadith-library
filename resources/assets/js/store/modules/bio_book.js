import Alert from '../../classes/alert';
import Book from '../../classes/book';

/**
 * This is the Book module.
 */

export default {

  namespaced: true,

  state: {

    books: null,
    book: null,

  },

  mutations: {

    storeBooks(state, data) {
      state.books = data;
    },

    addBook(state, book) {
        if(!state.books){
          state.books = [];
        }
        state.books.push(book);
    },

    storeBook(state, book){
      state.book = book;
    },

  },

  actions: {

    getAll: function({dispatch, commit, state}, data) {

      if(state.books){
        return;
      }


      dispatch('modal/show', 'loading', {root: true});
      dispatch('modal/setMessage', 'Loading...', {root: true});

      axios.get('/vue/bio_books')
      .then( ({data}) => {
        commit('storeBooks', data.books);
        dispatch('modal/hide', 'loading', {root: true});

      })
      .catch( (response) => {

        Alert.dispatch(response.data.message, 'error');
        dispatch('modal/hide', 'loading', {root: true});

      });




    }, //End of action

    addBook: function({dispatch, commit, state}, data) {

      axios.post('/vue/bio_book/create', data)
      .then( ({data}) => {

        commit('addBook', data.book);
        dispatch('modal/hide', 'addBioBook', {root: true});
        Alert.dispatch('Book successfully added', 'success');

      })
      .catch(({response}) => {
        Alert.dispatch(response.data.message, 'error');

      });

    },

    storeBook: function({dispatch, commit, state}, data){

      var book = new Book(data);
      commit('storeBook', book);


    },

/*
   getBook: function({dispatch, commit, state}, book_id){

      if(state.books && state.books.id == book_id){
        return;
      }

      axios.get('/vue/bio_books/book/' + book_id)
      .then(function({data}){
        console.log(data.book);
        dispatch('storeBook', data.book);
      })
      .catch();
    },
*/

  },

}
