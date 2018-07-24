<template>

          <v-list v-if="books">
            <div v-for="book in books" :key="book.id">
              <v-list-tile>
                <v-list-tile-content class="book_name" @click.prevent='openBook(book)'>
                  <v-list-tile-title>
                    {{book.name}}
                  </v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action v-if="$isAllowed('auth') && complete">
                  <v-btn icon small @click.prevent="selectBook(book)"><v-icon small>edit</v-icon></v-btn>
                </v-list-tile-action>
              </v-list-tile>

              <v-divider></v-divider>
            </div>
          </v-list>

</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

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

    getBooks: function() {
      this.$store.dispatch('book/getAll');
    },

    show: function(modal) {

      this.$store.dispatch('modal/show', modal);

    },

    hide: function(modal) {

      this.$store.dispatch('modal/hide', modal);

    },

    openBook(book){

      if(this.complete){
        this.$store.dispatch('book/storeBook', book);
        this.$router.push({ name: 'openBook', params: { book_id: book.id } } );
        
      } else {
        this.$store.dispatch('book/storeLinkedBook', book);
      }


    },

    selectBook: function(book){
      console.log(book);
      this.$store.dispatch('book/storeBook', book);
      this.show('editBook');
    },



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
