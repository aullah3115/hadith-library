<template>
  <v-card>
    <v-toolbar class="toolbar" card color="primary">
      <v-toolbar-title>Add a new hadith</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon @click.native="hide('addHadith')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>

    </v-toolbar>

    <v-card-text>
      <v-form @submit.prevent="addHadith">
        <p v-if="number">
          Hadith number {{number}} in this section
        </p>

        <v-textarea name="chain" label="Hadith chain" v-model="chain" rows="3" light></v-textarea>

        <v-textarea name="body" label="Hadith body" v-model="body" rows="5" light></v-textarea>


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

    parent: function(){
      return this.$store.state.section.parent;
    }
  },

  mounted: function(){

  },

  methods: {
    addHadith: function(){
      let data = {
        'section_id': this.parent.id,
        'number': this.number,
        'chain': this.chain,
        'body': this.body,
        'book': this.parent.book.name,
        'section': this.parent.name,
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
