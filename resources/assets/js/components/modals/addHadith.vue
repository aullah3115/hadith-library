<template>
  <v-card>
    <v-toolbar class="toolbar" card dark color="primary">
      <v-toolbar-title>Add a new hadith</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon dark @click.native="hide('addHadith')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>

    </v-toolbar>

    <v-card-text>
      <v-form @submit.prevent="addHadith">
        <v-text-field label="Number in baab" name="number" type="number" v-model="number" required></v-text-field>

        <v-text-field name="chain" label="Hadith chain" v-model="chain" textarea rows="3" light></v-text-field>

        <v-text-field name="body" label="Hadith body" v-model="body" textarea rows="5" light></v-text-field>


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
      number: '',
      chain: '',
      body: '',

    }
  },

  computed: {
    section_id: function(){
      return this.$route.params.parent_id;
    }
  },

  mounted: function(){

  },

  methods: {
    addHadith: function(){
      let data = {
        'section_id': this.section_id,
        'number': this.number,
        'chain': this.chain,
        'body': this.body,
      }
      
      this.$store.dispatch('hadith/addHadith', data);

    },

    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    },

  },

}


</script>

<style>


</style>
