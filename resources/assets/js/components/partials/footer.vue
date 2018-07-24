<template>
    <div>
      <v-footer color="secondary">
       <p>footer</p>

      </v-footer>

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

  },

  methods: {


    show(form) {
      this.$store.dispatch('modal/show', form);
    },

    hide(form) {
      this.$store.dispatch('modal/hide', form);
    },


  },

  perimeters: [
    authPerimeter,
  ],
}


</script>

<style>

</style>
