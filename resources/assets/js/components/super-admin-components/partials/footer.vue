<template>
    <div>
      <v-footer color="primary" app>
        <v-select
                @change="changeLanguage"
                item-text="name"
                return-object
                :items="locales"
                :placeholder="$t('message.language')"

                read>
        </v-select>

      </v-footer>

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

    locales: {
      get(){return this.$store.state.locales;}
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
      this.$router.go(-1);
    },

    goNext(){
      this.$router.go(1);
    },

    changeLanguage: function(value){
      this.$i18n.locale = value.code;
      this.$store.dispatch('changeLocale', value);
     // value.dir == 'rtl' ? this.$vuetify.rtl = true: this.$vuetify.rtl = false ;

    }

  },

  perimeters: [
    authPerimeter,
  ],
}


</script>

<style>

</style>
