<template>

    <v-card>
      <!--v-toolbar card dark color="primary">
        <v-toolbar-title>Create a new account</v-toolbar-title>

         <v-spacer></v-spacer>

         <v-toolbar-items>
           <v-btn icon dark @click.native="hide('register')">
             <v-icon>close</v-icon>
           </v-btn>
         </v-toolbar-items>

      </v-toolbar-->

      <v-card-text>
        <h1>{{message}}</h1>
      </v-card-text>
    </v-card>

</template>

<script>
export default {
  data: function(){
    return {

    }
  }, // end of data

  computed: {
    message: {
      get(){return this.$store.state.modal.loadingMessage;}
    }
  },

  methods: {



      show: function(modal){
        this.$store.dispatch('modal/show', modal);
      },

      hide: function(modal){
        this.$store.dispatch('modal/hide', modal);
      },
  }, // end of methods

}
</script>

<style>


</style>
