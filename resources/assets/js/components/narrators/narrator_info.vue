<template>
  <div>
    <h1>Narrator info</h1>

  </div>
</template>

<script>
import authPerimeter from '../../perimeters/auth';

export default {
  props: [
    'narrator_id',
  ],
  data: function(){
    return {

    }
  },

  computed: {

  },

  created: function(){

  },

  methods: {

    getNarrator: function(){
        this.$store.dispatch('narrator/getById', this.narrator_id)
    },

  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style>


</style>
