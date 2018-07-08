<template>

          <v-list v-if="books">
            <div v-for="book in books">
              <v-list-tile>
                <v-list-tile-content class="book_name" @click.prevent='openBook(book)'>
                  <v-list-tile-title>
                    {{book.name}}
                  </v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action>
                  <v-btn v-if="$isAllowed('auth') && complete" flat color="info">Edit - TODO</v-btn>
                </v-list-tile-action>
              </v-list-tile>

              <v-divider></v-divider>
            </div>
          </v-list>

</template>

<script>
import authPerimeter from '../../perimeters/auth';

export default {
  props: {
    complete: {
      type: Boolean,
      default: true,
    }
  },
  data: function(){
    return {

    };
  },

  computed: {
    books(){
        return this.$store.state.book.books;
    },


  },

  created: function(){
    this.getBooks();

  },

  methods: {

    /**
     * This method retrieves all
     * books from the server
     */

    getBooks: function() {
      this.$store.dispatch('book/getAll');
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

    openBook(book){



      if(this.complete){
        this.$store.dispatch('book/storeBook', book);
        this.$router.push('/books/book/' + book.id );
      } else {
        this.$store.dispatch('book/storeLinkedBook', book);
      }


    }



  },

  perimeters: [
    authPerimeter,
  ],

}

</script>

<style scoped>
.book_name{
  color: #3E2723;
  cursor: pointer;
}

.book_name:hover {
  background-color: #E8EAF6;
}

</style>
