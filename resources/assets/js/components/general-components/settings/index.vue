<template>
    <div>
        <h1>{{$t('message.settings')}}</h1>
        <v-select 
                @change="changePrimaryColor" 
                :items="primary_colors" 
                read
                label="Select a primary theme">
        </v-select>
        <v-select
                @change="changeLanguage"
                item-text="name"
                return-object
                :items="locales"
                :placeholder="$t('message.language')"
                read>
        </v-select>
    </div>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  data: function(){
    return {
    }
  },

  computed: {
      primary_colors: {
          get(){return this.$store.state.primary;}
      },

      locales: 
        {get(){return this.$store.state.locales;}
      },
  },

  mounted: function(){

  },

  methods: {
      changePrimaryColor: function(value){
          this.$vuetify.theme.primary = value;
          //this.$store.dispatch('changePrimaryColor', value);
      },

        changeLanguage: function(value){
            this.$i18n.locale = value.code;
           // this.$store.dispatch('changeLocale', value);
            value.dir == 'rtl' ? this.$vuetify.rtl = true: this.$vuetify.rtl = false ;

        },
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style>


</style>
