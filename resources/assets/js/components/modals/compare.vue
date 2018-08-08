<template>
  <v-card>
    
      <v-toolbar color="primary" card>
        <v-toolbar-title>Comparison of these two ahaadith</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon small @click.prevent="hide('compare')"><v-icon small>close</v-icon></v-btn>
      </v-toolbar>

      <v-card-text>
        <span v-for="object in change_objects">

        <span v-if="object.removed">
          <span>--</span><span class="red_text">{{object.value}} </span>
        </span>

        <span v-else-if="object.added">
          <span>++</span><span class="green_text">{{object.value}} </span>
        </span>

        <span v-else>
          <span class="blue_text">{{object.value}} </span>
        </span>

      </span>

      <v-divider></v-divider>
      <v-list>
        <v-list-tile>Blue = found in both hadith</v-list-tile>
        <v-list-tile>Red = only in first hadith</v-list-tile>
        <v-list-tile>Green = only in second hadith</v-list-tile>
      </v-list>
      <v-divider></v-divider>
      <div class="chains" v-if="hadith && compare_hadith">
        <div class="first_chain">
          <h1>Current hadith chain</h1>
         
          <v-list>
            <div v-for="link in first_chain" :key="link.id">
              <v-list-tile class="red" v-if="link.unique" @click="openNarrator(link.narrator.id)">
                <v-list-tile-content>{{link.narrator.chain.position}}. {{link.narrator.used_name}}</v-list-tile-content>
                <v-list-tile-action>
                  Click to view                  
                </v-list-tile-action>
              </v-list-tile>
              <v-list-tile class="blue" v-else @click="openNarrator(link.narrator.id)">
                <v-list-tile-content>{{link.narrator.chain.position}}. {{link.narrator.used_name}}</v-list-tile-content>
                <v-list-tile-action>
                  Click to view                  
                </v-list-tile-action>
              </v-list-tile>
              <v-divider></v-divider>
            </div>
            
            
            
          </v-list>
        </div>

        <div class="second_chain">
          <h1>Related hadith chain</h1>
        
          <v-list>
            <div v-for="link in second_chain" :key="link.id">
              <v-list-tile class="green" v-if="link.unique" @click="openNarrator(link.narrator.id)">
                <v-list-tile-content>{{link.narrator.chain.position}}. {{link.narrator.used_name}}</v-list-tile-content>
                <v-list-tile-action>
                  Click to view                  
                </v-list-tile-action>
              </v-list-tile>
              <v-list-tile class="blue" v-else @click="openNarrator(link.narrator.id)">
                <v-list-tile-content>{{link.narrator.chain.position}}. {{link.narrator.used_name}}</v-list-tile-content>
                <v-list-tile-action>
                  Click to view                  
                </v-list-tile-action>
              </v-list-tile>
              <v-divider></v-divider>
            </div>
            
            
            
          </v-list>
        </div>
        
        
      </div>
      
      </v-card-text>
      
    
  </v-card>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  data: function(){
    return {
      change_objects: null,
    }
  },

  computed: {
    hadith: {
      get(){return this.$store.state.hadith.hadith;}
    },
    compare_hadith: {
      get(){return this.$store.state.hadith.compare_hadith;}
    },

    first_chain(){
      return this.$store.getters['hadith/first_chain'];
    },

    second_chain(){
      return this.$store.getters['hadith/second_chain'];
    },

  },

  mounted: function(){
    this.change_objects = diff.diffWords(this.hadith.body, this.compare_hadith.body);
    this.getChains();
  },

  watch: {
    hadith: function(value){
      this.change_objects = diff.diffWords(this.hadith.body, this.compare_hadith.body);
      this.getChains();
    },
    compare_hadith: function(value){
      this.change_objects = diff.diffWords(this.hadith.body, this.compare_hadith.body);
      this.getChains();
    }
  },

  methods: {
    
    hide: function(modal){
      
      this.$store.dispatch('modal/hide', modal);
    },
    
    getChains: function(){
      this.$store.dispatch('hadith/getChain', this.hadith.id);
      this.$store.dispatch('hadith/getRelatedChain', this.compare_hadith.id);

    },
    openNarrator: function(id){
      this.$router.push({name: 'narrator', params: {narrator_id: id}});
      this.hide('compare');
    },
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>

.red_text {
  color: red;
}

.green_text {
  color: darkgreen;
}

.blue_text {
  color: blue;
}



@media screen and (min-width: 800px){
  .chains{
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-column-gap: 10px;
    grid-template-areas: 
    "first_chain second_chain";
  }

  .first_chain{
    grid-area: first_chain;
  }

  .second_chain{
    grid-area: second_chain;
  }
}
</style>
