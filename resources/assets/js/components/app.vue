<template>

  <v-app class="app">

    <div v-cloak class="v-container">




        <c-navBar>

        </c-navBar>

        <div class="searchbar">

          <c-search-button>

          </c-search-button>
        </div>


        <router-view name="main" class="main">


        </router-view>







        <c-modals></c-modals>

        <c-alert>


        </c-alert>

    </div>

  </v-app>



</template>

<script>

export default {
  data(){
    return {

    }
  },
  computed: {
    alert(){
      return this.$store.state.alert.value;
    },

  },
  mounted: function() {
    this.$store.dispatch('user/checkAuth');
    this.$store.dispatch('getLanguages');
  },
  methods: {

  },

}

</script>

<style scoped>
[v-cloak]{
  display: none;
}



.searchbar {
  position:fixed;
  margin-top: 100px;
  width: 100%;
  z-index: 1;
  background-color: #1A237E;
}

.main{

  margin-top: 160px;

}
.app{
  background-color: #1A237E;
}

.v-container {
  margin: 0px;
}

</style>
