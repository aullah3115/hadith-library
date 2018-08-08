<template>
    <v-card>
        <v-toolbar color="primary">
            <v-toolbar-title>Get in touch</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn small icon @click="hide('contact')">
                <v-icon small>close</v-icon>
            </v-btn>
        </v-toolbar>

        <v-card-text>
            <v-form @submit.prevent="submit()">
                <v-text-field label="Your email address" value="email" type="email" v-model="email"></v-text-field>

                <v-textarea label="Message" v-model="message" rows="5"></v-textarea>

                <v-btn type="submit" flat color="primary">Submit</v-btn>
            </v-form>
        </v-card-text>
    </v-card>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  data: function(){
    return {
        email: '',
        message: '',
    }
  },

  computed: {

  },

  mounted: function(){

  },

  methods: {
      show(form) {
      this.$store.dispatch('modal/show', form);
    },

    hide(form) {
      this.$store.dispatch('modal/hide', form);
    },

    submit(){
        let data = {
            email: this.email,
            message: this.message,
        };
        this.$store.dispatch('submitContactForm', data)
    }
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style>


</style>
