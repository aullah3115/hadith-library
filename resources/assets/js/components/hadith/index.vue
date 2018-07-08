<template>
  <div class="grid" v-if="hadith">

    <div class="header">
      <a @click="openBook(hadith.section.book.id)"><h1 class="text-md-center">{{hadith.section.book.name}}</h1></a>
      <h2 class="text-md-center">{{hadith.section.name}}</h2>
      <v-divider></v-divider>
    </div>







        <v-card class="chain">
          <v-toolbar color="yellow darken-2">
            <v-toolbar-title>
              Chain
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-toolbar-items class="mr-0">
              <v-btn color="yellow darken-3" @click.native="show('addLink')">
                <v-icon>add</v-icon>
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <c-chain :hadith_id="hadith_id"></c-chain>

        </v-card>



    <div class="hadith">

        <v-card class="text">
          <v-toolbar color="yellow darken-2">
            <v-toolbar-title>Hadith text</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            {{hadith.chain}} {{hadith.body}}
          </v-card-text>
        </v-card>

    </div>

    <div v-if="$mq == 'lg'" id="tabs" class="tabs">
      <v-tabs v-model="tab">
        <v-tab>
          Commentaries
        </v-tab>

        <v-tab>
          Translations
        </v-tab>

        <v-tab>
          Related Hadith
        </v-tab>

        <v-tab>
          Narrator information
        </v-tab>

        <v-tab-item class="tab-item">
          <c-hadith-comments :hadith_id="hadith_id"></c-hadith-comments>
        </v-tab-item>

        <v-tab-item class="tab-item">
            <c-hadith-translations :hadith_id="hadith_id"></c-hadith-translations>
        </v-tab-item>

        <v-tab-item class="tab-item">
            <c-related-hadiths :hadith_id="hadith_id"></c-related-hadiths>
        </v-tab-item>

        <v-tab-item id="narrators" class="tab-item">
          <c-hadith-narrators></c-hadith-narrators>
        </v-tab-item>

      </v-tabs>
    </div>

    <div v-if="$mq == 'sm' || $mq == 'md'" class="tabs">
      <v-card>
        <v-toolbar color="yellow darken-2">
          <v-toolbar-title>
            More information
          </v-toolbar-title>

          <v-spacer></v-spacer>

          <v-toolbar-items class="mr-0">
          
          </v-toolbar-items>
        </v-toolbar>

        <v-expansion-panel focusable v-model="panel">
          <v-expansion-panel-content :key="1">
            <div slot="header">Commentaries</div>
            <c-hadith-comments :hadith_id="hadith_id"></c-hadith-comments>
          </v-expansion-panel-content>

          <v-expansion-panel-content :key="2">
            <div slot="header">Translations</div>
                <c-hadith-translations :hadith_id="hadith_id"></c-hadith-translations>
          </v-expansion-panel-content>

          <v-expansion-panel-content :key="3">
            <div slot="header">Related Hadith</div>
                <c-related-hadiths :hadith_id="hadith_id"></c-related-hadiths>
          </v-expansion-panel-content>

          <v-expansion-panel-content :key="4" id="narrators">
            <div slot="header">Narrators</div>
            <c-hadith-narrators></c-hadith-narrators>
          </v-expansion-panel-content>
        </v-expansion-panel>

      </v-card>

    </div>




  </div>
</template>

<script>
import authPerimeter from '../../perimeters/auth';

export default {

  props: [
    'hadith_id',
  ],
  data: function(){
    return {
      tabs: null,
      //panel: null,
    }
  },

  computed: {

    showAddNarrator: {
      get(){return this.$store.state.modal.modals.addNarrator;}
    },

    showAddCommentary: {
      get(){return this.$store.state.modal.modals.addCommentary;}
    },

    hadith(){
      return this.$store.state.hadith.hadith;
    },

    tab: {
      get(){return this.$store.state.hadith.tab;},
      set(tab){this.$store.commit('hadith/select_tab', tab);}

    },
    panel: {
      get(){return this.$store.state.hadith.panel;},
      set(panel_no){this.$store.commit('hadith/select_panel', panel_no);}
    }
  },

  created: function(){
    this.getHadith();
    this.getChain();
  },

  methods: {
    goBack: function(){
      this.$router.go(-1);
    },

    getHadith: function(){

      this.$store.dispatch('hadith/getHadith', this.hadith_id);
    },

    getChain: function(){
      this.$store.dispatch('hadith/getChain', this.hadith_id);
    },

    openBook: function(id){
      this.$router.push('/books/book/' + id);
    },

    openSection: function(id){
      this.$router.push('/vue/sections/section/' + id);
    },

    show: function(modal) {
      this.$store.dispatch('modal/show', modal);
    },

    hide: function(modal) {
      this.$store.dispatch('modal/hide', modal);
    },

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
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: 100px 400px auto;
  grid-column-gap: 10px;
  grid-row-gap: 15px;
  grid-template-areas:
  ". header header ."
  "chain hadith hadith hadith"
  "tabs tabs tabs tabs";
  overflow: hidden;
}


.header
{
  grid-area: header;

}

.chain
{
  height: 100%;
  grid-area: chain;

}

.links
{
  overflow-y: auto;
  grid-area: links;
  height: 100%;
}


.hadith
{
  grid-area: hadith;
  height: 100%;
  overflow-y: auto;
}



.tabs
{
  grid-area: tabs;
}

.tab-item{
  height: 400px;
  overflow-y: hidden;
}

@media screen and (max-width: 800px) {
  .grid
  {
    display: grid;
    grid-template-columns: 100%;
    grid-template-rows: auto;
    grid-column-gap: 10px;
    grid-row-gap: 15px;
    grid-template-areas:
    "header"
    "hadith"
    "chain"
    "tabs";
    overflow: hidden;
  }

  .hadith{
    max-height: 300px;
  }


}

</style>
