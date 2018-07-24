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
    linked_book: null,

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

    editBook(state, book) {
     // state.books.push(book);
      
      let index = state.books.findIndex(function(element){
        
        return element.id == book.id;
      });
      
      state.books.splice(index, 1, book);
      
  },

    storeBook(state, book){
      state.book = book;
    },

    storeLinkedBook(state, book){
      state.linked_book = book;
    },

    unselectLinkedBook(state){
      state.linked_book = null;
    }

  },

  actions: {

    getAll: function({dispatch, commit, state}, data) {

      if(state.books){
        return;
      }


      dispatch('modal/show', 'loading', {root: true});
      dispatch('modal/setMessage', 'Loading...', {root: true});

      axios.get('/vue/books')
      .then( ({data}) => {
        commit('storeBooks', data.books);
        dispatch('modal/hide', 'loading', {root: true});

      })
      .catch( ({response}) => {

        Alert.dispatch(response.data.message, 'error');
        dispatch('modal/hide', 'loading', {root: true});

      });




    }, //End of action

    addBook: function({dispatch, commit, state}, data) {

      axios.post('/vue/book/create', data)
      .then( ({data}) => {
        commit('addBook', data.book);
        dispatch('modal/hide', 'addBook', {root: true});
        Alert.dispatch('Book successfully added', 'success');

      })
      .catch(({response}) => {
        Alert.dispatch(response.data.message, 'error');

      });

    },

    editBook: function({dispatch, commit, state}, data) {

      axios.post('/vue/book/edit/', data)
      .then( ({data}) => {
        commit('editBook', data.book);
        dispatch('modal/hide', 'editBook', {root: true});
        Alert.dispatch('Book successfully edited', 'success');

      })
      
      .catch(({response}) => {
        Alert.dispatch(response.data, 'error');

      });
      
    },

    storeBook: function({dispatch, commit, state}, book){

      //var book = new Book(data);
      commit('storeBook', book);


    },

    storeLinkedBook: function({dispatch, commit, state}, data){

      var book = new Book(data);
      commit('storeLinkedBook', book);


    },

   getBook: function({dispatch, commit, state}, book_id){

      if(state.book && state.book.id == book_id){
        return;
      }

      if(state.book){
        state.book = null;
      }

      axios.get('/vue/books/book/' + book_id)
      .then(function({data}){
        dispatch('storeBook', data.book);
      })
      .catch();
    },

    getLinkedBook: function({dispatch, commit, state}, book_id){

       if(state.linked_book && state.linked_book.id == book_id){
         return;
       }

       if(state.linked_book){
         state.linked_book = null;
       }

       axios.get('/vue/books/book/' + book_id)
       .then(function({data}){
         dispatch('storeLinkedBook', data.book);
       })
       .catch();
     },

    unselectLinkedBook: function({commit, dispatch}){
      dispatch('section/unselectLinkedSections', null, {root:true});
      commit('unselectLinkedBook');
    },


  },



}
