<template>
    <div>

      <v-toolbar app color="admin" height="70px">

        <v-toolbar-side-icon @click.stop="show('navDrawer')"></v-toolbar-side-icon>

        <mq-layout mq="lg+">
          <v-btn icon small :to="{ name: 'home', params: {} }" active-class>
            <v-icon small>fas fa-home</v-icon>
          </v-btn>
        </mq-layout>

        <mq-layout mq="lg+">
          <v-btn small icon @click="goBack">
            <v-icon small v-if="rtl">arrow_forward</v-icon>
            <v-icon small v-else>arrow_back</v-icon>
          </v-btn>

          <v-btn small icon @click="goNext">
            <v-icon small v-if="rtl">arrow_back</v-icon>
            <v-icon small v-else>arrow_forward</v-icon>
          </v-btn>
        </mq-layout>

        <v-toolbar-title>Super-admin page</v-toolbar-title>

        <v-spacer></v-spacer>

        <mq-layout mq="lg+">
          <v-toolbar-items>

            <v-btn small flat @click.native="show('searchbar')">
              {{$t('message.search')}}
            </v-btn>

              <v-btn small flat :to="{ name: 'about', params: {} }"  active-class>
                {{$t('message.about')}}
              </v-btn>

              <v-btn v-if="$isAllowed('guest')" small flat @click.stop="show('login')">
                {{$t('message.sign_in')}}
              </v-btn>

              <v-btn v-if="$isAllowed('guest')" small flat @click.stop="show('register')">
                {{$t('message.create_account')}}
              </v-btn>

              <v-menu v-if="$isAllowed('auth')">
                <v-btn small flat slot="activator">
                    {{$t('message.profile')}}
                </v-btn>


                <v-list>

                  <v-list-tile @click='goToProfile'>
                    {{$t('message.profile')}}
                  </v-list-tile>

                  <v-divider></v-divider>

                  <v-list-tile @click="logout">
                      {{$t('message.sign_out')}}
                  </v-list-tile>


                </v-list>
              </v-menu>

          </v-toolbar-items>
        </mq-layout>

        <mq-layout :mq="['sm', 'md']">
          <v-toolbar-items>

            <v-menu>
              <v-btn icon slot="activator">
                  <v-icon right>more_vert</v-icon>
              </v-btn>


              <v-list>

                <v-list-tile v-if="$isAllowed('auth')" @click='goToProfile'>
                  {{$t('message.profile')}}
                </v-list-tile>

                <v-list-tile v-if="$isAllowed('auth')" @click="logout">
                    {{$t('message.sign_out')}}
                </v-list-tile>

                <v-list-tile  @click="show('login')" flat v-if="$isAllowed('guest')">
                  {{$t('message.sign_in')}}
                </v-list-tile>

                <v-list-tile  @click="show('register')" flat v-if="$isAllowed('guest')">
                  {{$t('message.create_account')}}
                </v-list-tile>

              </v-list>
            </v-menu>

          </v-toolbar-items>
        </mq-layout>

      </v-toolbar>

    </div>

</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  data() {
    return {

    }
  },

  computed: {
    direction: {
      get(){return this.$store.state.dir;}
    },
    rtl:{
      get(){return this.$store.state.rtl;}
    },
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
