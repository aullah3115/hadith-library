<template>
  <v-card>
    
      <v-toolbar color="primary" card>
        <v-toolbar-title>All related hadith</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon small @click.prevent="hide('compareAll')"><v-icon small>close</v-icon></v-btn>
      </v-toolbar>

      <v-card-text>
        <v-card>
          <v-card-text>
            <h3>Currently selected hadith</h3>
            <p v-if="hadith">{{hadith.body}}</p>
            <v-divider></v-divider>
            <h3>Chain for currently selected hadith</h3>
            <v-list>
              <v-list-tile v-for="link in chain" :key="link.id" @click="openNarrator(link.id)">
                <v-list-tile-content>{{link.chain.position}}. {{link.used_name}}</v-list-tile-content>
                <v-list-tile-action>
                  Click to view                  
                </v-list-tile-action>

              </v-list-tile>
            </v-list>
          </v-card-text>
        </v-card>
        
        <v-list>
          <v-list-tile>Blue = found in selected hadith also</v-list-tile>
          <v-list-tile>Red = only found in selected hadith</v-list-tile>
          <v-list-tile>Green = not present in selected hadith</v-list-tile>
        </v-list>

        <v-container fill-height grid-list-md>
          <v-layout row wrap fill-height>
            <v-flex xs12 sm6 md6 lg4 xl4 v-for="related in related_hadiths" :key="related.id" fill-height>

               <v-card>
                 <v-card-title><h2>{{related.section}} - {{related.book}}</h2></v-card-title>
                 <v-card-text>
                   <v-expansion-panel expand>
                     <v-expansion-panel-content>
                      <div slot="header">Hadith text</div>
                      <v-card>
                        <v-card-text>
                          <p>{{related.body}}</p>
                        </v-card-text>
                      </v-card>
                      
                    </v-expansion-panel-content>

                    <v-expansion-panel-content>
                      <div slot="header">Text comparison</div>
                        <v-card>
                          <v-card-text>
                            <span v-for="object in related.change_objects">

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
                          </v-card-text>
                        </v-card>
                         
                    </v-expansion-panel-content>

                    <v-expansion-panel-content>
                      <div slot="header">Chain</div>
                      <v-card>
                        <v-card-text>
                          <v-list>
                            <div v-for="link in related.links" :key="link.id">
                              <v-list-tile class="red" v-if="link.unique" @click="openNarrator(link.id)">
                                <v-list-tile-content>{{link.chain.position}}. {{link.used_name}}</v-list-tile-content>
                                <v-list-tile-action>
                                  Click to view                  
                                </v-list-tile-action>
                              </v-list-tile>
                              <v-list-tile class="blue" v-else @click="openNarrator(link.id)">
                                <v-list-tile-content>{{link.chain.position}}. {{link.used_name}}</v-list-tile-content>
                                <v-list-tile-action>
                                  Click to view                  
                                </v-list-tile-action>
                              </v-list-tile>
                              <v-divider></v-divider>
                            </div>
                      </v-list>
                        </v-card-text>
                      </v-card>
                      
                    </v-expansion-panel-content>
                   </v-expansion-panel>
                                     
                 </v-card-text>

                

              </v-card>       

            </v-flex>
          </v-layout>
        </v-container>
       
      
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
    
    chain:{
        get(){return this.$store.state.hadith.chain;}
    },

    related_hadiths(){
      return this.$store.getters['hadith/all_related_hadiths'];
    },
    
  },

  mounted: function(){
    //this.change_objects = diff.diffWords(this.hadith.body, this.compare_hadith.body);
    
  },

  watch: {
    hadith: function(value){
     // this.change_objects = diff.diffWords(this.hadith.body, this.compare_hadith.body);
     
    },
  },

  methods: {
    
    hide: function(modal){
      
      this.$store.dispatch('modal/hide', modal);
    },
    
    openNarrator: function(id){
      this.$router.push({name: 'narrator', params: {narrator_id: id}});
      this.hide('compareAll');
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
</style>
