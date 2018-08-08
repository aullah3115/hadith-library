<template>
    <mq-layout mq="lg+">
        
      <v-navigation-drawer :right="$vuetify.rtl" width="500" :clipped="false" app :temporary="true" :disable-resize-watcher="true" v-if="tree && directory" v-model="directory">
        
        <v-toolbar color="primary">
          <v-toolbar-title>Library</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon small @click="toggleDirectory()">
            <v-icon small>close</v-icon>
          </v-btn>
        </v-toolbar>
        <c-tree :nodes="tree.contains" name="Books" :depth="-1"></c-tree>
      </v-navigation-drawer>
    </mq-layout>
 

</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
    
  data: function(){
    return {

    };
  },

  computed: {
    directory:{
        get(){return this.$store.state.directory;},
        set(value){this.$store.commit("toggleDirectory", value)}
    },
    tree(){
        return this.$store.state.book.tree;
    },


  },

  created: function(){
    this.getTree();

  },

  methods: {

    /**
     * This method retrieves all
     * books from the server
     */

    getTree: function() {
      this.$store.dispatch('book/getTree');
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

    toggleDirectory: function(){
        this.$store.dispatch('toggleDirectory', !this.$store.state.directory)
        
      //this.$store.dispatch('toggleDirectory', !this.$store.state.directory)
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
