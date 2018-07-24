<template>
  <div>
    <h1 class="text-xs-center">Search Results</h1>

    <v-btn v-if="results && show" color="primary" @click="group_results()">Group results</v-btn>
    <v-btn v-if="results && !show" color="primary" @click="ungroup_results()">Unroup results</v-btn>
    
    <v-list v-if="results  && show" three-line>
      <div v-for="result in results" :key="result._id">

        <div v-if="result._index == 'hadith'">
          <v-list-tile @click="openHadith(result._id)">
            <v-list-tile-content>
              <v-list-tile-title>
                Hadith: {{result._source.book}}
              </v-list-tile-title>
              <v-list-tile-sub-title>
                <text-highlight :queries="search_terms">{{result._source.body | truncate(100)}}</text-highlight>
              </v-list-tile-sub-title>

            </v-list-tile-content>
          </v-list-tile>
        </div>

        <div v-else-if="result._index == 'commentary'">
          <v-list-tile @click="openCommentary(result._id)">
            <v-list-tile-content>
              <v-list-tile-title>
                Commentary: {{result._source.book}}
              </v-list-tile-title>
              <v-list-tile-sub-title>
                <text-highlight :queries="search_terms">{{result._source.text | truncate(100)}}</text-highlight>
              </v-list-tile-sub-title>

            </v-list-tile-content>
          </v-list-tile>
        </div>

        <div v-else-if="result._index == 'bio'">
          <v-list-tile @click="openBio(result._id)">
            <v-list-tile-content>
              <v-list-tile-title>
                Biography: {{result._source.narrator}} <br />

              </v-list-tile-title>
              <v-list-tile-sub-title>
                Source: {{result._source.book}}
              </v-list-tile-sub-title>
              <v-list-tile-sub-title>
                <text-highlight :queries="search_terms">{{result._source.text | truncate(100)}}</text-highlight>
              </v-list-tile-sub-title>

            </v-list-tile-content>
          </v-list-tile>
        </div>

        <div v-else-if ="result._index == 'narrator'">
          <v-list-tile @click="openNarrator(result._id)">
            <v-list-tile-content>
              Narrator: {{result._source.used_name}}
            </v-list-tile-content>
          </v-list-tile>
        </div>


        <div v-else></div>

        <v-divider></v-divider>
      </div>
    </v-list>

    <v-expansion-panel>
      <v-expansion-panel-content v-if="hadiths.length > 0">
        <div slot="header">Ahaadith</div>
        <v-list three-line>

          <div v-for="hadith in hadiths" :key="hadith._id">
            <v-list-tile @click="openHadith(hadith._id)">
              <v-list-tile-content>
                <v-list-tile-title>
                  {{hadith._source.book}}
                </v-list-tile-title>
                <v-list-tile-sub-title>
                  <text-highlight :queries="search_terms">{{hadith._source.body | truncate(100)}}</text-highlight>
                </v-list-tile-sub-title>

              </v-list-tile-content>

            </v-list-tile>
            <v-divider></v-divider>
          </div>
        </v-list>
      </v-expansion-panel-content>

      <v-expansion-panel-content v-if="commentaries.length > 0">

        <div slot="header">Commentaries</div>
        <v-list>

          <div v-for="commentary in commentaries" :key="commentary._id">
            <v-list-tile @click="openCommentary()">
              <v-list-tile-content>
                <v-list-tile-title>
                  {{commentary._source.book}}
                </v-list-tile-title>
                <v-list-tile-sub-title>
                  <text-highlight :queries="search_terms">{{commentary._source.text | truncate(100)}}</text-highlight>
                </v-list-tile-sub-title>

              </v-list-tile-content>

            </v-list-tile>
            <v-divider></v-divider>
          </div>
        </v-list>
      </v-expansion-panel-content>

      <v-expansion-panel-content v-if="bios.length > 0">
        <div slot="header">Biographies</div>
        <v-list>

          <div v-for="bio in bios" :key="bio._id">
            <v-list-tile @click="openBio()">
              <v-list-tile-content>
                <v-list-tile-title>
                  {{bio._source.narrator}}
                </v-list-tile-title>
                <v-list-tile-sub-title>
                  Source: {{bio._source.book}}
                </v-list-tile-sub-title>
                <v-list-tile-sub-title>
                  <text-highlight :queries="search_terms">{{bio._source.text}}</text-highlight>
                </v-list-tile-sub-title>
              </v-list-tile-content>

            </v-list-tile>
            <v-divider></v-divider>
          </div>
        </v-list>
      </v-expansion-panel-content>

      <v-expansion-panel-content v-if="narrators.length > 0">
        <div slot="header">Narrators</div>
        <v-list>
          <div v-for="narrator in narrators" :key="narrator._id">
            <v-list-tile @click="openNarrator()">
              <v-list-tile-content>
                {{narrator._source.used_name}}
              </v-list-tile-content>

            </v-list-tile>
            <v-divider></v-divider>
          </div>
        </v-list>
      </v-expansion-panel-content>
    </v-expansion-panel>


  </div>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  data: function(){
    return {
      hadiths: [],
      commentaries: [],
      narrators: [],
      bios: [],
      show: true,
    }
  },

  computed: {
    results: function(){
      return this.$store.state.search_results;
    },
    results1: function(){
      return this.$store.state.search_results1;
    },
    grouped_results: function(){

    },
    search_terms: {
      get(){return this.$store.state.search_terms;}
    }

  },

  mounted: function(){

  },

  methods: {

    group_results: function(){
      let results = this.results;
      //console.log(results);
      for(var i = 0; i < results.length; i++){
      //  console.log(results[i]);
        switch (results[i]._index) {
          case 'hadith':
            this.hadiths.push(results[i]);
            break;
          case 'commentary':
            this.commentaries.push(results[i]);
            break;
          case 'narrator':
            this.narrators.push(results[i]);
            break;
          case 'bio':
            this.bios.push(results[i]);
            break;
          default:
        }
      }
      this.show = false;
    },

    ungroup_results(){
      this.hadiths =[];
      this.bios = [];
      this.narrators =[];
      this.commentaries =[];

      this.show = true;
    },

    openHadith: function(id){

        this.$router.push({name: 'hadith', params: {hadith_id: id}});
        return;
    },

    openNarrator: function(id){
      this.$router.push({name: 'narrator', params: {narrator_id: id}});
      return;
    },

    openCommentary: function(id){
      //this.$router.push({name: 'narrator_info', params: {narrator_id: id}});
      return;
    },

    openBio: function(id){
      //this.$router.push({name: 'narrator_info', params: {narrator_id: id}});
      return;
    },

  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style>


</style>
