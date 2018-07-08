<template>

    <v-card>
      <v-toolbar card dark color="primary">
        <v-toolbar-title>Relate hadith</v-toolbar-title>

         <v-spacer></v-spacer>

         <v-toolbar-items>
           <v-btn icon dark @click.native="hide('linkHadith')">
             <v-icon>close</v-icon>
           </v-btn>
         </v-toolbar-items>

      </v-toolbar>

      <v-card-text class="grid">
        <v-card class="hadith">
          <v-toolbar card>
            <v-toolbar-title>Currently selected hadith</v-toolbar-title>
          </v-toolbar>

          <v-card-text>
            {{current_hadith.body}}
          </v-card-text>

        </v-card>

        <div class="linked_hadith">
          <v-card v-if="linked_hadith">
            <v-toolbar card>
              <v-toolbar-title>Link to this hadith?</v-toolbar-title>

               <v-spacer></v-spacer>

               <v-toolbar-items>
                 <v-btn icon dark @click.native="unselectLinkedHadith()">
                   <v-icon>close</v-icon>
                 </v-btn>
               </v-toolbar-items>

            </v-toolbar>

            <v-card-text>
              {{linked_hadith.body}}
            </v-card-text>

            <v-form @submit.prevent="linkHadith()">
              <v-btn type="submit" name="submit">Submit</v-btn>
            </v-form>

          </v-card>

          <v-card v-else-if="linked_book">
            <v-toolbar card>
              <v-toolbar-title>Choose a section/hadith</v-toolbar-title>

               <v-spacer></v-spacer>

               <v-toolbar-items>
                 <v-btn icon dark @click.native="unselectLinkedBook()">
                   <v-icon>close</v-icon>
                 </v-btn>
               </v-toolbar-items>

            </v-toolbar>
            <c-linked-sections :book_id_prop="linked_book.id" :parent_id_prop="linked_parent_id"></c-linked-sections>

          </v-card>

          <v-card v-else>
            <v-toolbar card>
              <v-toolbar-title>Choose a book</v-toolbar-title>
            </v-toolbar>

            <v-card-text>
              <c-book-list :complete="false"></c-book-list>
            </v-card-text>
          </v-card>
        </div>

      </v-card-text>
    </v-card>

</template>

<script>
export default {
  data: function(){
    return {

    }
  }, // end of data

  computed: {
    linked_book(){
        return this.$store.state.book.linked_book;
    },
    linked_hadith(){

      return this.$store.state.hadith.linked_hadith;
    },
    linked_sections(){
      return this.$store.state.section.linked_sections;
    },
    current_hadith(){
      return this.$store.state.hadith.hadith;
    },
    linked_parent_id(){
      if(this.$store.state.section.linked_parent){
        return this.$store.state.section.linked_parent.id;
      }
      return null;
    },
    /*
    related_hadiths(){
      return this.$store.state.hadith.related_hadiths;
    }
    */
  },

  methods: {

      linkHadith() {

          let data = {
            hadith_1_id: this.current_hadith.id,
            hadith_2_id: this.linked_hadith.id,
          };

          this.$store.dispatch('hadith/linkHadith', data);

      },

      show: function(modal){
        this.$store.dispatch('modal/show', modal);
      },

      hide: function(modal){
        this.$store.dispatch('modal/hide', modal);
      },

      unselectLinkedHadith: function(){
        this.$store.dispatch('hadith/unselectLinkedHadith');
      },

      unselectLinkedBook: function(){
        this.$store.dispatch('book/unselectLinkedBook');
      },


  }, // end of methods

}
</script>

<style scoped>
.grid{
  display: grid;
  grid-template-columns: 100%;
  grid-template-rows: 150px 300px;
  grid-row-gap: 10px;
  grid-template-areas:
  "hadith"
  "linked_hadith";


}

.hadith{
  grid-area: hadith;
  overflow-y: auto;
  height: 100%;
  overflow-y: auto;

}

.linked_hadith{
  grid-area: linked_hadith;
  height: 100%;
  overflow-y: auto;

}

</style>
