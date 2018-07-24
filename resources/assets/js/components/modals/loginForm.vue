<template>
  <v-card>
    <v-toolbar card dark color="primary">
      <v-toolbar-title>Sign in to your account</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon dark @click.native="hide('login')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>

    </v-toolbar>

    <v-card-text>
      <v-form @submit.prevent="login">

        <v-text-field label="email" name="email" v-model="email" required></v-text-field>

        <v-text-field
            name="password"
            v-model="password"
            label="Enter your password"
            hint="At least 8 characters"
            min="8"
            :append-icon="hidePassword ? 'visibility' : 'visibility_off'"
            @click:append="() => (hidePassword = !hidePassword)"
            value=""
            class="input-group--focused"
            :type="hidePassword ? 'password' : 'text'"
          ></v-text-field>

          <v-btn type="submit" block color="primary" large round>Submit</v-btn>


      </v-form>
    </v-card-text>
  </v-card>

</template>

<script>
export default {
    data() {
        return {
            hidePassword: true,
            email: '',
            password: '',
        };
    },

    methods: {
        login() {

          //this.$store.dispatch('nav/toggleLoginForm');
          this.$store.dispatch('modal/hide', 'login');
          this.$store.dispatch('modal/show', 'loading');
          this.$store.dispatch('modal/setMessage', 'Attempting to sign in...');



            let user =
              {
                email: this.email,
                password: this.password
              };

            this.$store.dispatch('user/login', user);

        },

        show: function(modal){
          this.$store.dispatch('modal/show', modal);
        },

        hide: function(modal){
          this.$store.dispatch('modal/hide', modal);
        },

    }
}
</script>

<style>

</style>
