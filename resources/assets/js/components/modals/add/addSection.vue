<template>
<v-card>
  <v-toolbar card color="primary">
    <v-toolbar-title>Add a new section</v-toolbar-title>

     <v-spacer></v-spacer>

     <v-toolbar-items>
       <v-btn icon @click.native="hide('addSection')">
         <v-icon>close</v-icon>
       </v-btn>
     </v-toolbar-items>

  </v-toolbar>

  <v-card-text>
    <v-form @submit.prevent="addSection()">

      <h3>Add section at position {{position}}</h3>

      <v-text-field label="Name of section" name="name" v-model="name" required></v-text-field>

      <v-switch :label="`Contains other sections`" v-model="has_section"></v-switch>

      <v-switch :label="`Contains hadith`" v-model="has_hadith"></v-switch>

      <v-btn flat color="primary" type="Submit">Submit</v-btn>

    </v-form>

  </v-card-text>
</v-card>

</template>

<script>
export default {
  props: [
    //'book_id',
    //'parent_id',
  ],
  data: function(){
    return {
      name: null,
      has_hadith: false,
      has_section: false,

    }
  },

  computed: {
    position: function(){
      let sections = this.$store.state.section.sections;
      if(sections){
        return Object.values(sections).length + 1;
      }
    },

    book_id: function(){
      if(this.$route.params.book_id){
        return this.$route.params.book_id;
      }
      return null;
    },

    parent_id: function(){
      if(this.$route.params.parent_id){
        return this.$route.params.parent_id;
      }
      return null;
    },
  },

  mounted: function(){

  },

  methods: {
    addSection: function(){
    let data = {
      book_id: this.book_id,
      parent_id: this.parent_id,
      position: this.position,
      name: this.name,
      has_section: this.has_section,
      has_hadith: this.has_hadith,
    }
    console.log(data);
    //return;
    this.$store.dispatch('modal/hide', 'addSection')
    this.$store.dispatch('section/addSection', data);
  },

  hide: function(modal){
    this.$store.dispatch('modal/hide', modal);
  },

  }, // end of methods

}


</script>

<style>


</style>
