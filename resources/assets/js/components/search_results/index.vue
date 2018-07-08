<template>
  <div>
    <h1>Search Results</h1>

    <v-list v-if="results" three-line>
      <div  v-for="result in results">

        <div v-if="result._index == 'hadith'">
          <v-list-tile @click="openHadith(result._id)">
            <v-list-tile-content>
              Hadith: {{result._source.body | truncate(100)}}
            </v-list-tile-content>
          </v-list-tile>
        </div>

        <div v-else-if="result._index == 'commentary'">
          <v-list-tile @click="openCommentary(result._id)">
            <v-list-tile-content>
              Commentary: {{result._source.book}}
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

        <v-divider></v-divider>
      </div>

    </v-list>
  </div>
</template>

<script>
import authPerimeter from '../../perimeters/auth';

export default {
  data: function(){
    return {

    }
  },

  computed: {
    results: function(){
      return this.$store.state.search_results;
    }
  },

  mounted: function(){

  },

  methods: {

    openHadith: function(id){

        this.$router.push({name: 'hadith', params: {hadith_id: id}});
        return;
    },

    openNarrator: function(id){
      this.$router.push({name: 'narrator_info', params: {narrator_id: id}});
      return;
    },

    openCommentary: function(id){
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
