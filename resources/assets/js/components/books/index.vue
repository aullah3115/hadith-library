<template>

  <div class="grid">

      <v-card class="body">

        <v-toolbar class="title" color="blue darken-1">
          <v-toolbar-title class="yellow--text text--lighten-5">Books in the library</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items class="mr-0">
            <v-btn class="yellow--text text--lighten-5" depressed color="yellow darken-3" small v-if="$isAllowed('auth')" @click.stop="show('addBook')">
              Add new Collection
            </v-btn>
          </v-toolbar-items>

        </v-toolbar>

        <v-card-text class="books">
        <c-book-list></c-book-list>

        </v-card-text>

      </v-card>

  </div>

</template>

<script>
import authPerimeter from '../../perimeters/auth';

export default {
  data: function(){
    return {

    };
  },

  computed: {
/*
    books(){
        return this.$store.state.book.books;
    },
*/

  },

  created: function(){
    //this.getBooks();

  },

  methods: {

    /**
     * This method retrieves all
     * books from the server
     */

    getBooks: function() {
    //  this.$store.dispatch('book/getAll');
    },

    /**
     * This method is used to show or hide the AddBook form.
     * If the form is being toggled off, it will first,
     * reset the steps to the beginning
     */

    show: function(modal) {

      this.$store.dispatch('modal/show', modal);

    },

    hide: function(modal) {

      this.$store.dispatch('modal/hide', modal);

    },
/*
    openBook(book){


      this.$store.dispatch('book/storeBook', book);
      this.$router.push('/books/book/' + book.id );

    },
*/


  },

  perimeters: [
    authPerimeter,
  ],

}

</script>

<style scoped>
.grid
{
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: 400px;
  grid-column-gap: 10px;
  grid-row-gap: 15px;
  grid-template-areas:
  "body body body body";
  overflow-y: hidden;
}

.header
{
  grid-area: header;

}

.body {
  grid-area: body;
  display: grid;
  grid-template-rows: 64px auto;
  grid-template-areas:
  "title"
  "books";
}

.title{
  grid-area: title;
}

.books{
  grid-area: books;
  overflow-y: auto;
}

</style>
