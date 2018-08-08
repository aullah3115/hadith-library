<template>
   <v-card  class="suggested_hadith">
          <v-card-text class="content">

            <v-card v-if="suggested_hadith" height="100%">
              <v-toolbar color="primary">
                <v-toolbar-title>Hadith from {{suggested_hadith.section.book.name}}</v-toolbar-title>
                <v-spacer></v-spacer>


                  <v-btn icon small @click.native="unselectSuggestedHadith()">
                    <v-icon>close</v-icon>
                  </v-btn>

              </v-toolbar>

              <div class="content">
                <v-card-text>
                  {{suggested_hadith.body}}
                </v-card-text>
              </div>

            </v-card>
                     
                <v-list v-if="suggested_hadiths" color="primary" three-line>
                  <div v-for="hadith in suggested_hadiths" :key="hadith.id">
                    <v-list-group>
                    <v-list-tile  slot="activator">

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
                          <v-btn @click="openHadith(hadith.id)" color="primary">Open Hadith</v-btn>
                          <v-btn @click="compare(hadith)" color="primary">Compare</v-btn>
                          <v-btn @click="linkHadith(hadith.id)" color="primary">Link Hadith</v-btn>
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
  props: {
    hadith_id: {
      type: [Number, String]

    },
  },

  data: function(){
    return {

    }
  },

  computed: {
    suggested_hadiths: {
      get(){return this.$store.state.hadith.suggested_hadiths;}
    },

    suggested_hadith: {
      get(){return this.$store.state.hadith.suggested_hadith;}
    },

    current_hadith: {
      get(){return this.$store.state.hadith.hadith;}
    },
  },

  mounted: function(){
    //console.log(this.book_id + '/' + this.parent_id);
    this.getSuggestedHadiths();
  },

  watch: {
    '$route': 'getSuggestedHadiths',
  },

  methods: {

    getSuggestedHadiths: function(){
      this.$store.dispatch('hadith/getSuggestedHadiths', this.hadith_id);
    },

   selectSuggestedHadith: function(id){

      this.$store.dispatch('hadith/selectSuggestedHadith', id);
    },

    unselectSuggestedHadith: function(){
      this.$store.dispatch('hadith/unselectSuggestedHadith');
    },

    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    compare: function(hadith){
      let vue = this;
      this.$store.dispatch('hadith/storeCompareHadith', hadith)
      .then( function(){
        vue.show('compare');
      })
      
    },

    openHadith: function(id){
      this.$router.push({name: 'hadith', params: {hadith_id: id}});
      
      return;
    },

    linkHadith(id) {

          let data = {
            hadith_1_id: this.current_hadith.id,
            hadith_2_id: id,
          };

          this.$store.dispatch('hadith/linkHadith', data);

      },

  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>
.suggested_hadith{
  overflow-y: auto;
  max-height: 400px;
}

.content {
  height: 100%;
  overflow-y: auto;
}
</style>
