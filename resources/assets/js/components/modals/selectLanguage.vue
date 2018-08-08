<template>
  <v-card>
    <v-toolbar card color="primary">
      <v-spacer></v-spacer>
      <v-toolbar-title>Choose a language</v-toolbar-title>
      <v-spacer></v-spacer>

    </v-toolbar>

    <v-card-text>
        <v-form @submit.prevent="goHome()">
            <v-container align-center align-content-center>
                <h3 class="text-xs-center">Currently selected: {{selected}}</h3>
            
        
                <v-list v-if="locales">
                    <v-list-tile v-for="locale in locales" :key="locale.code" @click="changeLanguage(locale)">
                        <v-list-tile-title class="text-xs-center">{{locale.name}}</v-list-tile-title>
                    </v-list-tile>
                </v-list>
                
                <v-btn block depressed color="primary" type="submit">Continue</v-btn>
            
            </v-container>
        </v-form>

    </v-card-text>

  </v-card>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  data: function(){
    return {
      selected: 'English',
    }
  },

  computed: {
      locales: 
        {get(){return this.$store.state.locales;}
      },
  },

  mounted: function(){

  },

  methods: {
    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    },

    goHome: function(){
      this.$router.push({name: 'home'});
    },

     changeLanguage: function(value){
        this.$i18n.locale = value.code;
        this.selected = value.name;
        // this.$store.dispatch('changeLocale', value);
        value.dir == 'rtl' ? this.$vuetify.rtl = true: this.$vuetify.rtl = false ;

    },
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>


</style>
