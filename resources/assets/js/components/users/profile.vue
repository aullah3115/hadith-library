<template>

  <div>
    <p>
      Name: {{user.name}}
    </p>
    <p>
      Email: {{user.email}}
    </p>

    <p>
      Change Password - TODO
    </p>
  </div>

</template>

<script>
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

}


</script>

<style>


</style>
