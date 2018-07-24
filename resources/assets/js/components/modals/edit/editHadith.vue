<template>
  <v-card>
    <v-toolbar class="toolbar" card color="primary">
      <v-toolbar-title>Edit hadith</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon @click.native="hide('editHadith')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>

    </v-toolbar>

    <v-card-text>
      <v-form @submit.prevent="editHadith">
        <p v-if="number">
          Hadith number {{hadith.number}} in this {{hadith.section.name}}
        </p>

        <v-textarea name="chain" label="Hadith chain" v-model="chain" rows="5" light></v-textarea>

        <v-textarea name="body" label="Hadith body" v-model="body" rows="10" light></v-textarea>


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
      //number: '',
      chain: '',
      body: '',

    }
  },

  computed: {
    number: function(){
      let hadith = this.$store.state.hadith.hadiths;
      if(hadith){
        return Object.values(hadith).length + 1;
      }

    },

    hadith: {
      get(){return this.$store.state.hadith.hadith;}
    },

    parent: function(){
      return this.$store.state.section.parent;
    }
  },

  mounted: function(){
    this.chain = this.hadith.chain;
    this.body = this.hadith.body;
  },

  methods: {
    editHadith: function(){
      let data = {
        id: this.hadith.id,
        //'section_id': this.hadith.section.id,
        //'number': this.hadith.number,
        chain: this.chain,
        body: this.body,
      }

      this.$store.dispatch('hadith/editHadith', data);

    },

    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    },

  },

}


</script>

<style>


</style>
