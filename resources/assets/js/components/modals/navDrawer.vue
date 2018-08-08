<template>

    <v-card>
      <v-toolbar card color="primary">
        <v-toolbar-title>Menu</v-toolbar-title>

         <v-spacer></v-spacer>

         <v-toolbar-items>
           <v-btn icon @click.native="hide('navDrawer')">
             <v-icon>close</v-icon>
           </v-btn>
         </v-toolbar-items>

      </v-toolbar>

      <v-card-text>
        <v-list>

          <v-list-tile @click="hide('navDrawer')" :to="{name: 'home', props: {}}" exact>
            <span class="text-xs-center">{{$t("message.home")}}</span>
          </v-list-tile>

          <v-list-tile @click="hide('navDrawer')" :to="{name: 'books', props: {}}" exact>
            <span class="text-xs-center">{{$t("message.library")}}</span>
          </v-list-tile>

          <v-list-tile @click="hide('navDrawer')" :to="{name: 'about', props: {}}" exact>
            <span class="text-xs-center">{{$t("message.about")}}</span>
          </v-list-tile>

          <v-list-tile v-if="$isAllowed('auth')" @click="hide('navDrawer')" :to="{name: 'profile', props: {}}" exact>
            <span class="text-xs-center">{{$t("message.profile")}}</span>
          </v-list-tile>

          <v-list-tile @click="hide('navDrawer')" :to="{name: 'settings', props: {}}" exact>
            <span class="text-xs-center">{{$t("message.settings")}}</span>
          </v-list-tile>

        </v-list>
      </v-card-text>
    </v-card>

</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

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

  perimeters: [
    authPerimeter,
  ],

}
</script>

<style scoped>
span {
  width: 100%;
}

</style>
