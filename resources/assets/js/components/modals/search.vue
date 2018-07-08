<template>
  <v-card>
    <v-toolbar card dark color="primary">
      <v-toolbar-title>Search</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon dark @click.native="hide('searchbar')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>

    </v-toolbar>

    <v-card-text>
      <v-form @submit.prevent="submit">
        <v-text-field autofocus placeholder="Enter your search query here..." min="1" outline v-model="query"></v-text-field>

        <v-checkbox v-model="index" label="Ahaadith" value="hadith"></v-checkbox>
        <v-checkbox v-model="index" label="Commentaries" value="commentary"></v-checkbox>
        <v-checkbox v-model="index" label="Narrators" value="narrator"></v-checkbox>
        <v-btn depressed color="blue" type="submit">Submit</v-btn>
      </v-form>

    </v-card-text>

  </v-card>
</template>

<script>
import authPerimeter from '../../perimeters/auth';

export default {
  data: function(){
    return {
      query: '',
      index: [],
    }
  },

  computed: {

  },

  mounted: function(){

  },

  methods: {
    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    },

    submit: function(){
      let data = {
        query: this.query,
        index: this.index,
      }
      if(data.query.length < 1){return}
      this.hide('searchbar')
      this.$store.dispatch('submitQuery', data);
      this.$router.push({name: 'search_results'})
    }
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>


</style>
