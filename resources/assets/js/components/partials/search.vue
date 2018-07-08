<template>
  <div class="search">

      <v-btn @click.native="show('searchbar')" block depressed color="blue">To open search click here<v-spacer></v-spacer><v-icon>fas fa-search</v-icon></v-btn>

  </div>
</template>

<script>
import authPerimeter from '../../perimeters/auth';

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
    show: function(modal) {
      this.$store.dispatch('modal/show', modal);
    },
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>
.search {
  padding: 0px 10px;
}

</style>
