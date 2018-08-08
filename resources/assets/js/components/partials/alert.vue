<template>
  <div>
    <v-snackbar :right="true" :vertical="true" v-model="value" :bottom="true" :timeout="6000" :color="type">
      {{ message }}

      <v-btn
          color="pink"
          flat
          @click="dismiss"
        >
          Close
        </v-btn>
    </v-snackbar>

    <!--change to snackbar???-->

  </div>

</template>

<script>
export default {

  data: function(){
    return {

    }
  },

  computed: {

    message(){
      return this.$store.state.alert.message;
    },

    type() {
      return this.$store.state.alert.type;
    },

    value() {
      return this.$store.state.alert.value;
    },

    timeout(){
      return this.$store.state.alert.timeout;
    }


  },

  methods: {
    dismiss: function(){
      this.$store.dispatch('alert/dismiss');
    }
  }


}

</script>

<style>


</style>
