<template>
  <v-card>
    <v-toolbar card dark color="primary">
      <v-toolbar-title>{{$t('message.search')}}</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon dark @click.native="hide('searchbar')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>

    </v-toolbar>

    <v-card-text>
      <v-form @submit.prevent="submit">
        <v-text-field autofocus label="Enter your search query here..." min="1" outline v-model="query"></v-text-field>

        <v-checkbox v-model="index" label="Ahaadith" value="hadith"></v-checkbox>
        <v-checkbox v-model="index" label="Commentaries" value="commentary"></v-checkbox>
        <v-checkbox v-model="index" label="Narrators" value="narrator"></v-checkbox>
        <v-checkbox v-model="index" label="Biographies" value="bio"></v-checkbox>
        <v-btn depressed color="primary" type="submit">{{$t('message.submit')}}</v-btn>
      </v-form>

    </v-card-text>

  </v-card>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

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
