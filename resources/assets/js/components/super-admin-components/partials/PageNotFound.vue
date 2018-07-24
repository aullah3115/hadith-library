<template>
  <div>
    <h1>The Page you are looking forr could not be found. Navigate back using the back arrow above or click here to go to <router-link :to="{ name: 'home', params: {} }">the home page</router-link></h1>
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
