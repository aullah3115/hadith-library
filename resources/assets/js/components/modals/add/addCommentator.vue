<template>
<v-card>
  <v-toolbar card dark color="primary">
    <v-toolbar-title>Add a new commentator</v-toolbar-title>

     <v-spacer></v-spacer>

     <v-toolbar-items>
       <v-btn icon dark @click.native="hide('addCommentator')">
         <v-icon>close</v-icon>
       </v-btn>
     </v-toolbar-items>

  </v-toolbar>

  <v-card-text>
    <v-form @submit.prevent="addCommentator">
      <v-layout row wrap>
        <v-flex xs12 sm 6>
          <v-text-field solo label="Kunyah" v-model="kunyah"></v-text-field>
        </v-flex>
      </v-layout>

      <v-layout row wrap>
        <v-flex xs12 sm6>
          <v-text-field solo label="Name" v-model="name" required></v-text-field>
        </v-flex>
        <v-flex xs12 sm6>
          <v-text-field solo label="Commonly used name" v-model="used_name"></v-text-field>
        </v-flex>
      </v-layout>

      <v-layout row wrap>
        <v-flex xs12 sm6>
          <v-text-field solo label="Laqab" v-model="laqab"></v-text-field>
        </v-flex>
        <v-flex xs12 sm6>
          <v-text-field solo label="Nisbah" v-model="nisbah"></v-text-field>
        </v-flex>
      </v-layout>

      <v-layout row wrap>
        <v-flex xs12 sm6>
          <v-text-field solo label="Year of birth" type="number" v-model="yob"></v-text-field>
        </v-flex>

        <v-flex xs12 sm6>
          <v-text-field solo label="Year of death" type="number" v-model="yod"></v-text-field>
        </v-flex>
      </v-layout>


      <v-btn type="submit" flat color="primary">Submit</v-btn>
    </v-form>
  </v-card-text>
</v-card>

</template>

<script>
export default {
  data: function(){
    return {
      kunyah: "",
      name: "",
      laqab: "",
      used_name: "",
      nisbah: "",
      yob: "",
      yod: "",
    }
  },

  computed: {

  },

  mounted: function(){

  },

  methods: {
    addCommentator: function(){
      let data = {
        kunyah: this.kunyah,
        name: this.name,
        laqab: this.laqab,
        used_name: this.used_name,
        nisbah: this.nisbah,
        yob: this.yob,
        yod: this.yod,
      };

      this.$store.dispatch('commentator/addCommentator', data);
    },

    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    }
  }, // end of methods

}


</script>

<style>


</style>
