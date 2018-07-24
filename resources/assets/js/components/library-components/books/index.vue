<template>

  <div class="grid">

      <v-card class="body">

        <v-toolbar class="title" color="primary">
          <v-toolbar-title>{{$t('message.books_title')}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items class="mr-0">
            <v-btn icon small v-if="$isAllowed('auth')" @click.stop="show('addBook')">
              <v-icon small>add</v-icon>
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
import authPerimeter from '@/acl/perimeters/auth';

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
  grid-template-columns:100%;
  grid-template-rows: 400px;
  grid-row-gap: 15px;
  grid-template-areas:
  "body";
  overflow-y: hidden;
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
