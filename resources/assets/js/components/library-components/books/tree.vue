<template>

          <div>
            <div class="branch" :style="indent" v-if="node">
              <v-list-tile>
                <v-list-tile-avatar>
                  <v-btn icon small v-if="nodes && !showChildren" @click="toggleChildren()">
                    <v-icon small color="green">add</v-icon>                   
                  </v-btn>

                  <v-btn icon small v-if="nodes && showChildren" @click="toggleChildren()">
                    <v-icon small color="red">remove</v-icon>
                  </v-btn>
                </v-list-tile-avatar>
                <v-list-tile-content>
                  <v-list-tile-title :style="bold">
                    <span v-if="depth > 0 && !$vuetify.rtl">
                      <v-icon small>subdirectory_arrow_right</v-icon>
                    </span>
                    <span v-if="depth > 0 && $vuetify.rtl">
                      <v-icon small>subdirectory_arrow_left</v-icon>
                    </span> {{name}} 
                  </v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action>
                  
                  <v-btn color="primary" flat small @click="open()">
                    Open                  
                  </v-btn>

                  
                  
                </v-list-tile-action>
              </v-list-tile> 
              <v-divider></v-divider>
              
            </div>
            <div v-if="showChildren">
              <c-tree v-for="node in nodes" :key="node.id" :node="node" :name="node.name" :nodes="node.contains" :depth="depth + 1"></c-tree>
            </div>
            
          </div>

</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  props: [
    "name",
    "nodes",
    "depth",
    "node",
    
  ],
  data: function(){
    return {
      showChildren: false,
      root: false,
    };
  },

  computed: {
    indent() {
        
        return this.$vuetify.rtl ? { transform: `translate(${this.depth * -40}px)` } : { transform: `translate(${this.depth * 40}px)` };
      },
      bold() {
        switch (this.depth) {
          case 0:
            return {"font-weight": 900};
            break;
          case 1:
            return {"font-weight": 500};
            break;
          case 3:
            return {"font-weight": 100};
          default:
            break;
        }
       // return { transform: `translate(${this.depth * -40}px)` };
      }
  },

  created: function(){
    if(this.name == "Books"){
      this.showChildren = true;
      this.root = true;
    }

  },

  methods: {

    getTree: function() {
      this.$store.dispatch('book/getTree');
    },

    toggleChildren: function(){
      this.showChildren = !this.showChildren;
    },

    open: function(){
      this.toggleDirectory();
      if(this.node._type == 'Book'){
        this.$router.push({name: 'openBook', params: {book_id: this.node.sql_id}})
        return;
      }
      
      this.$router.push({name: 'openSection', params: {parent_id: this.node.sql_id}})
      
    },

    toggleDirectory: function(){
      this.$store.dispatch('toggleDirectory', !this.$store.state.directory)
    },

    /*

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

  */

  },

  perimeters: [
    authPerimeter,
  ],

}

</script>

<style scoped>
.branch{
  max-width: 350px;
}

.bold{
  font-weight: bold;
}

</style>
