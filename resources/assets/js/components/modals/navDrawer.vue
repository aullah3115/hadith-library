<template>

    <v-card>
      <v-toolbar card dark color="primary">
        <v-toolbar-title>Menu</v-toolbar-title>

         <v-spacer></v-spacer>

         <v-toolbar-items>
           <v-btn icon dark @click.native="hide('navDrawer')">
             <v-icon>close</v-icon>
           </v-btn>
         </v-toolbar-items>

      </v-toolbar>

      <v-card-text>
        <v-list>
          <v-list-tile @click="hide('navDrawer')" :to="{name: 'home', props: {}}">Home</v-list-tile>
          <v-list-tile @click="hide('navDrawer')" :to="{name: 'books', props: {}}">Library</v-list-tile>
          <v-list-tile @click="hide('navDrawer')" :to="{name: 'about', props: {}}">About</v-list-tile>
          <v-list-tile @click="hide('navDrawer')" :to="{name: 'profile', props: {}}">Profile</v-list-tile>
        </v-list>
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
