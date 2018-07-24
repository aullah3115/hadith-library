<template>
    <div>
      <v-bottom-nav height="40" v-if="$mq == 'sm' || $mq =='md'" fixed :value="true" color="primary" app>

            <v-spacer></v-spacer>

            <v-btn small icon @click="goBack">
              <v-icon small v-if="$vuetify.rtl">arrow_forward</v-icon>
              <v-icon small v-else>arrow_back</v-icon>
            </v-btn>

            <v-spacer></v-spacer>

            <v-btn small icon :to="{ name: 'home', params: {} }" active-class>
              <v-icon small>home</v-icon>
            </v-btn>

            <v-spacer></v-spacer>

            <v-btn small icon @click.native="show('searchbar')">
              <v-icon small>search</v-icon>
            </v-btn>

            <v-spacer></v-spacer>
      </v-bottom-nav>

    </div>

</template>

<script>
import authPerimeter from '../../perimeters/auth';

export default {
  data() {
    return {

    }
  },

  computed: {
    rtl: {
      get(){return this.$store.state.rtl;}
    }
  },

  methods: {


    show(form) {
      this.$store.dispatch('modal/show', form);
    },

    hide(form) {
      this.$store.dispatch('modal/hide', form);
    },

    goBack(){
      console.log(this.$vuetify.rtl);
      this.$router.go(-1);
    },

    goNext(){
      this.$router.go(1);
    },

  },

  perimeters: [
    authPerimeter,
  ],
}


</script>

<style>

</style>
