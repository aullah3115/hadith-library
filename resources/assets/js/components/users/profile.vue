<template>

  <div>
    <p>
      {{$t('message.name')}}: {{user.name}}
    </p>
    <p>
      {{$t('message.email')}}: {{user.email}}
    </p>

    <p>
      Edit Profile - TODO
    </p>

    <v-btn color="primary" :to="{ name: 'settings', params: {} }">Settings</v-btn>

    <v-btn color="admin" v-if="$isAllowed('superAdmin')" :to="{ name: 'super-admin-home', params: {} }">Open Admin page</v-btn>
    
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
    user(){
      return this.$store.state.user.user;
    }
  },

  mounted: function(){

  },

  methods: {
    
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style>


</style>
