<template>
  <v-card>
    <v-toolbar class="toolbar" card dark color="primary">
      <v-toolbar-title>Add a new language</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon dark @click.native="hide('addLanguage')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>

    </v-toolbar>

    <v-card-text>
      <v-form @submit.prevent="addLanguage">
        <v-text-field label="Name" name="name" type="text" v-model="name" required></v-text-field>

        <v-spacer></v-spacer>
        <v-btn flat color="primary" type="submit">Submit</v-btn>

      </v-form>
    </v-card-text>
  </v-card>



</template>

<script>
export default {

  data: function(){
    return {
      name: '',


      //narrator: '',
    }
  },

  computed: {

  },

  mounted: function(){

  },

  methods: {
    addLanguage: function(){
      let data = {
        'name': this.name,
      };

      this.$store.dispatch('addLanguage', data);

    },

    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    },

  },

}


</script>

<style>


</style>
