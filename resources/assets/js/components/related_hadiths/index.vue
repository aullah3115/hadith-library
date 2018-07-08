<template>
  <v-card>


    <v-card-text  class="grid">

      <v-card v-if="hadith" height="100%">
        <v-toolbar>
          <v-toolbar-title>Hadith from {{hadith.section.book.name}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>

            <v-btn icon @click.native="unselectHadith">
              <v-icon>close</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>

        <div class="content">
          <v-card-text>
            {{hadith.body}}
          </v-card-text>
        </div>

      </v-card>

      <v-card class="content" v-else height="100%">

        <v-toolbar>

          <v-toolbar-title>Related Hadith</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-toolbar-items>
            <v-btn color="yellow darken-3" v-if="$isAllowed('auth')" @click.native="show('linkHadith')">
              <v-icon>add</v-icon>
            </v-btn>
          </v-toolbar-items>

        </v-toolbar>

        <v-card-text>
          <v-list v-if="hadiths">
            <div v-for="hadith in hadiths">
              <v-list-tile @click.prevent='selectHadith(hadith.id)'>
                <v-list-tile-content>
                  <v-list-tile-title>
                    {{hadith.body}}
                  </v-list-tile-title>

                </v-list-tile-content>
              </v-list-tile>

              <v-divider></v-divider>
            </div>
          </v-list>
        </v-card-text>
      </v-card>





    </v-card-text>

  </v-card>

</template>

<script>
import authPerimeter from '../../perimeters/auth';

export default {
  props: [
    'hadith_id',
  ],
  data: function(){
    return {
      selected_hadith: null,
    }
  },

  computed: {
    hadiths: {
      get(){return this.$store.state.hadith.related_hadiths;}
    },
    hadith: {
      get(){return this.$store.state.hadith.related_hadith;}
    },
    current_hadith: {
      get(){return this.$store.state.hadith.hadith;}
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

    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    unselectHadith: function(){
      this.$store.dispatch('hadith/unselectRelatedHadith');
    },
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>
.grid{

  height: 400px;
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
    max-height: 400px;
  }
}

</style>
