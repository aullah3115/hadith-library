<template>
  <v-card>
    <v-toolbar class="toolbar" card color="primary">
      <v-toolbar-title>Add a new language</v-toolbar-title>

       <v-spacer></v-spacer>

         <v-btn icon small @click.native="hide('addLanguage')">
           <v-icon small>close</v-icon>
         </v-btn>

    </v-toolbar>

    <v-card-text>
      <v-form @submit.prevent="addLanguage">
        <v-text-field label="Name" name="name" type="text" v-model="name" required></v-text-field>

        <p>Direction</p>
        <v-radio-group v-model="direction">
          <v-radio label="Left to right" value="ltr"></v-radio>
          <v-radio label="Right to left" value="rtl"></v-radio>
        </v-radio-group>

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
      direction: '',

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
        name: this.name,
        direction: this.direction,
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
