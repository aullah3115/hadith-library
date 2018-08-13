<template>
  <v-card>


    <v-card-text  class="grid">

      <v-card v-if="translation" height="100%">
        <v-toolbar color="primary">
          <v-toolbar-title>Translation in {{translation.language.name}}</v-toolbar-title>
          <v-spacer></v-spacer>


            <v-btn icon small @click.native="unselectTranslation()">
              <v-icon small>close</v-icon>
            </v-btn>

        </v-toolbar>

        <div class="content">
          <v-card-text>
            {{translation.text}}
          </v-card-text>
        </div>

      </v-card>

      <v-card class="content" v-else height="100%">
        <v-toolbar color="primary">
          <v-toolbar-title>Select a translation</v-toolbar-title>
          <v-spacer></v-spacer>


            <v-btn icon small v-if="$isAllowed('auth')" @click.native="show('addTranslation')">
              <v-icon small>add</v-icon>
            </v-btn>
      

        </v-toolbar>
        <v-card-text>
          <v-list v-if="translations">
            <div v-for="translation in translations" :key="translation.id">
              <v-list-tile @click.prevent='selectTranslation(translation)'>
                <v-list-tile-content>
                  <v-list-tile-title>
                    {{translation.language.name}} - {{translation.translator}}
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
import authPerimeter from '@/acl/perimeters/auth';

export default {
  props: [
    'hadith_id',
  ],
  data: function(){
    return {
      selected_translation: null,
    }
  },

  computed: {
    translations: {
      get(){return this.$store.state.hadith_translation.translations;}
    },
    translation: {
      get(){return this.$store.state.hadith_translation.translation;}
    },
  },

  created: function(){
    this.getTranslations();
  },

  mounted: function(){

  },

  watch:{
    $route: function(to, from){
      this.getTranslations();
    },
  },

  methods: {
    getTranslations: function(){
      this.$store.dispatch('hadith_translation/getTranslations', this.hadith_id);
    },

    selectTranslation: function(translation){
      this.$store.dispatch('hadith_translation/selectTranslation', translation);
    },

    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    unselectTranslation: function(){
      this.$store.dispatch('hadith_translation/unselectTranslation');
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
