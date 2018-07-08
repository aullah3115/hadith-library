<template>
    <div>

      <v-toolbar app dark color="deep-purple darken-4" height="100px">





        <v-toolbar-side-icon v-if="$mq == 'sm' || $mq == 'md'" @click.stop="show('navDrawer')"></v-toolbar-side-icon>

        <mq-layout mq="lg+">
          <v-btn flat :to="{ name: 'home', params: {} }" active-class>
            <v-icon left>fas fa-home</v-icon>

          </v-btn>
        </mq-layout>

        <mq-layout mq="lg+">
          <v-btn flat icon @click="goBack">

            <v-icon v-if="$vuetify.rtl" left>fas fa-arrow-right</v-icon>
            <v-icon v-else left>fas fa-arrow-left</v-icon>
          </v-btn>
        </mq-layout>

        <mq-layout mq="lg+">
          <v-btn flat icon @click="goNext">
            <v-icon v-if="!$vuetify.rtl" left>fas fa-arrow-right</v-icon>
            <v-icon v-else left>fas fa-arrow-left</v-icon>
          </v-btn>
        </mq-layout>

        <v-toolbar-title class="white--text">Hadith Library</v-toolbar-title>

        <v-spacer></v-spacer>
        
        <mq-layout mq="lg+">
          <v-toolbar-items>

              <v-btn flat :to="{ name: 'about', params: {} }"  active-class>
                <v-icon left>fas fa-info-circle</v-icon>
                  About
              </v-btn>

              <v-btn v-if="$isAllowed('guest')" flat @click.stop="show('login')">
                Sign in
              </v-btn>

              <v-btn v-if="$isAllowed('guest')" flat @click.stop="show('register')">
                Create a new account
              </v-btn>

              <v-menu v-if="$isAllowed('auth')">
                <v-btn flat slot="activator">
                    My Profile
                  <v-icon right>fas fa-user-circle</v-icon>
                </v-btn>


                <v-list>

                  <v-list-tile @click='goToProfile'>
                    View Profile
                  </v-list-tile>

                  <v-list-tile @click="logout">
                      Sign Out
                  </v-list-tile>

                </v-list>
              </v-menu>

          </v-toolbar-items>
        </mq-layout>

        <mq-layout :mq="['sm', 'md']">
          <v-toolbar-items>
            <v-btn  @click="logout" flat v-if="$isAllowed('auth')">
              Sign out
            </v-btn>

            <v-btn  @click="show('login')" flat v-if="$isAllowed('guest')">
              Sign in
            </v-btn>
          </v-toolbar-items>
        </mq-layout>

      </v-toolbar>

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

  },

  methods: {
    logout: function() {


      this.$store.dispatch('modal/setMessage', 'Signing out...');
      this.$store.dispatch('modal/show', 'loading');
      this.$store.dispatch('user/logout')
      .then(() => {
        this.$router.push({name: 'home', params: {}});
      });


    },

    goToProfile(){
      this.$router.push({name: 'profile', params: {}});
    },

    show(form) {
      this.$store.dispatch('modal/show', form);
    },

    hide(form) {
      this.$store.dispatch('modal/hide', form);
    },

    goBack(){
      this.$router.go(-1);
    },

    goNext(){
      this.$router.go(1);
    },



    //toggleRegisterForm() {
      //this.$store.dispatch('nav/toggleRegisterForm');
    //}


  },

  perimeters: [
    authPerimeter,
  ],
}


</script>

<style>

</style>
