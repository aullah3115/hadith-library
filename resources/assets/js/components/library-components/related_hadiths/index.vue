<template>
     
<v-card>
  <v-card-text  class="grid">

    <v-card v-if="hadith" height="100%">
      <v-toolbar color="primary">
        <v-toolbar-title>Hadith from {{hadith.section.book.name}}</v-toolbar-title>
        <v-spacer></v-spacer>

          <v-btn flat @click.native="show('compare')">
            Compare
          </v-btn>

          <v-btn icon small @click.native="unselectHadith()">
            <v-icon>close</v-icon>
          </v-btn>

      </v-toolbar>

      <div class="content">
        <v-card-text>
          {{hadith.body}}
        </v-card-text>
      </div>

    </v-card>

   
      <v-toolbar color="primary">

        <v-toolbar-title>Related Hadith</v-toolbar-title>

        <v-spacer></v-spacer>


          <v-btn icon small v-if="$isAllowed('auth')" @click.native="show('linkHadith')">
            <v-icon>add</v-icon>
          </v-btn>


      </v-toolbar>

      
        <v-list v-if="hadiths" color="primary" three-line>
          <div v-for="hadith in hadiths" :key="hadith.id">
            <v-list-group>
              <v-list-tile slot="activator" @click="paginate(hadith.body, 100)">

                <v-list-tile-content>
                  <v-list-tile-title>
                    Book: {{hadith.book}}
                  </v-list-tile-title>

                  <v-list-tile-sub-title>
                    Section: {{hadith.section}} - Hadith no. {{hadith.position}}
                  </v-list-tile-sub-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-card>
                <v-card-text>
                  
                  <c-paginator :text="hadith.body" :words="100"></c-paginator>
                </v-card-text>
                <v-card-actions>
                  <v-btn @click="paginate(hadith.body, 20)">Open Hadith</v-btn>
                </v-card-actions>
              </v-card>              
            </v-list-group>

            <v-divider></v-divider>
          </div>
        </v-list>
     

  </v-card-text>

</v-card>     

</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  props: [
    'hadith_id',
  ],
  data: function(){
    return {
      selected_hadith: null,
      pages: null,
      page_no: 1,
    }
  },

  computed: {
    hadiths: {
      get(){return this.$store.state.hadith.related_hadiths;}
    },

    hadith: {
      get(){return this.$store.state.hadith.related_hadith;}
    },
    length: function(){
      
      return this.pages ? this.pages.length : 0;
    },
  },

  watch: {
    '$route': 'getRelatedHadiths',
  },

  created: function(){
    this.getRelatedHadiths();
  },

  mounted: function(){

  },

  methods: {
    getRelatedHadiths: function(){
      this.$store.dispatch('hadith/getRelatedHadiths', this.hadith_id);
    },

    selectHadith: function(id){

      this.$store.dispatch('hadith/selectRelatedHadith', id);
    },

    unselectHadith: function(){
      this.$store.dispatch('hadith/unselectRelatedHadith');
    },

    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    openHadith: function(hadith_id){
      return;
    },

    paginate: function(text, words_per_page = 50){
      let text_array = text.split(" ");
      let pages = [];
      
      for(let i = 0, j = 0; i < text_array.length; i += words_per_page, j++){
        let start_word_position = j * words_per_page;
        let end_word_position = words_per_page * (j + 1);
        let page;
        page = end_word_position > text_array.length 
        ? text_array.slice(start_word_position, text_array.length) 
        : text_array.slice(start_word_position, end_word_position);
        page = page.join(" ");
        pages.push(page);
      }
      this.pages = pages;
      
    },

  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>
.related_hadith{
  overflow-y: auto;
  max-height: 400px;
}
.grid{

  height: 300px;
  overflow-y: hidden;
}

.content {
  height: 100%;
  overflow: auto;
}

.comment{
  overflow-y: auto;
}

@media screen and (max-width: 800px) {
  .grid {
    height: auto;
  }
}

</style>
