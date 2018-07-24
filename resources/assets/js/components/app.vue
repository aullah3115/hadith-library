<template>

  <v-app class="app">

    <div v-cloak class="v-container">




        <c-navBar>

        </c-navBar>



        <router-view name="main" class="main">


        </router-view>

        <c-footer class="footer"></c-footer>

        <c-bottom-nav></c-bottom-nav>





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
  created: function() {
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


.main{
  margin: 70px 0px 0px;
  padding: 10px;
  padding-bottom: 100px;
  min-height: 100vh;
}

.footer{
  margin-bottom: 60px;
}

.v-container {
  margin: 0px;

}

.app{
  background-color: white;
}

</style>
