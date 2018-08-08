<template>
    <v-card>
        <v-card-text>
            <v-form>
                <span>Enable notifications?</span>
                <v-btn color="primary" @click="allowNotification()">Yes</v-btn>
                <v-btn @click="hide('askNotification')">No</v-btn>
            </v-form>
        </v-card-text>
    </v-card>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  data: function(){
    return {

    }
  },

  computed: {

  },

  mounted: function(){

  },

  methods: {
    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    },

    allowNotification(){
        askNotificationPermission();
    }
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style>


</style>
