<template>
   <v-card>
          <v-card-text  class="grid">

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
                      {{hadith.body}}
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
  },

  mounted: function(){
    //console.log(this.book_id + '/' + this.parent_id);
    this.getSuggestedHadiths();
  },

  watch: {
    //'$route': 'getHadiths',
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

  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>


</style>
