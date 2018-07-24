<template>

    <v-card>
      <v-toolbar card dark color="primary">
        <v-toolbar-title>Create a new account</v-toolbar-title>

         <v-spacer></v-spacer>

         <v-toolbar-items>
           <v-btn icon dark @click.native="hide('register')">
             <v-icon>close</v-icon>
           </v-btn>
         </v-toolbar-items>

      </v-toolbar>

      <v-card-text>
        <v-form @submit.prevent="register">

          <v-text-field label="Your Name" v-model="name" required :autofocus="true"></v-text-field>

          <v-text-field label="Your Username" v-model="username" required></v-text-field>

          <v-text-field label="Your Email" v-model="email" required></v-text-field>

          <v-text-field
              name="password"
              v-model="password"
              label="Enter your password"
              hint="At least 8 characters"
              min="8"
              :append-icon="hidePassword ? 'visibility' : 'visibility_off'"
              :append-icon-cb="() => (hidePassword = !hidePassword)"
              value=""
              class="input-group--focused"
              :type="hidePassword ? 'password' : 'text'"
            ></v-text-field>

            <v-text-field
                name="password_confirmation"
                v-model="password_confirmation"
                label="Confirm password"
                hint="At least 8 characters"
                min="8"
                :append-icon="hidePassword ? 'visibility' : 'visibility_off'"
                :append-icon-cb="() => (hidePassword = !hidePassword)"
                value=""
                class="input-group--focused"
                :type="hidePassword ? 'password' : 'text'"
              ></v-text-field>

            <v-btn color="primary" flat type="submit">Submit</v-btn>

        </v-form>
      </v-card-text>
    </v-card>

</template>

<script>
export default {
  data: function(){
    return {
      hidePassword: true,
      name: "",
      username: "",
      email: "",
      password: "",
      password_confirmation: "",
    }
  }, // end of data

  methods: {

      register() {

          let data = {
              name: this.name,
              username: this.username,
              email: this.email,
              password: this.password,
              password_confirmation: this.password_confirmation,
          };

          this.$store.dispatch('user/register', data);

      },

      show: function(modal){
        this.$store.dispatch('modal/show', modal);
      },

      hide: function(modal){
        this.$store.dispatch('modal/hide', modal);
      },
  }, // end of methods

}
</script>

<style scoped="">


</style>
