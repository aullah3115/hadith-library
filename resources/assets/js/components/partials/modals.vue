<template>
  <div>

    <v-dialog v-if="addBook" :scrollable="true" persistent v-model="addBook">
      <c-add-book></c-add-book>
    </v-dialog>

    <v-dialog v-if="addSection" :scrollable="true" persistent v-model="addSection">
      <c-add-section></c-add-section>
    </v-dialog>

    <v-dialog v-if="addHadith" :scrollable="true" persistent v-model="addHadith">
      <c-add-hadith></c-add-hadith>
    </v-dialog>

    <v-dialog v-if="addAuthor" :scrollable="true" persistent v-model="addAuthor">
      <c-add-author></c-add-author>
    </v-dialog>

    <v-dialog v-if="addHadithComment" :scrollable="true" persistent v-model="addHadithComment">
      <c-add-hadith-comment></c-add-hadith-comment>
    </v-dialog>

    <v-dialog v-if="addCommentary" :scrollable="true" persistent v-model="addCommentary">
      <c-add-commentary></c-add-commentary>
    </v-dialog>

    <v-dialog v-if="addCommentator" :scrollable="true" persistent v-model="addCommentator">
      <c-add-commentator></c-add-commentator>
    </v-dialog>

    <v-dialog v-if="addNarrator" :scrollable="true" persistent v-model="addNarrator">
      <c-add-narrator></c-add-narrator>
    </v-dialog>

    <v-dialog v-if="addLink" :scrollable="true" persistent v-model="addLink">
      <c-add-link></c-add-link>
    </v-dialog>

    <v-dialog v-if="addBio" :scrollable="true" persistent v-model="addBio">
      <c-add-bio></c-add-bio>
    </v-dialog>

    <v-dialog v-if="addBioAuthor" :scrollable="true" persistent v-model="addBioAuthor">
      <c-add-bio-author></c-add-bio-author>
    </v-dialog>

    <v-dialog v-if="addBioBook" :scrollable="true" persistent v-model="addBioBook">
      <c-add-bio-book></c-add-bio-book>
    </v-dialog>

    <v-dialog v-if="linkHadith" :scrollable="true" persistent v-model="linkHadith">
      <c-link-hadith></c-link-hadith>
    </v-dialog>

    <v-dialog v-if="addLanguage" :scrollable="true" persistent v-model="addLanguage">
      <c-add-language></c-add-language>
    </v-dialog>

    <v-dialog v-if="addTranslation" :scrollable="true" persistent v-model="addTranslation">
      <c-add-translation></c-add-translation>
    </v-dialog>

    <v-dialog :scrollable="true" v-model="login" persistent v-if="$isAllowed('guest') && login">
      <c-login></c-login>
    </v-dialog>

    <v-dialog :scrollable="true" v-model="register" persistent v-if="$isAllowed('guest') && register">
      <c-register></c-register>
    </v-dialog>

    <v-dialog v-if="loading" :scrollable="true" persistent v-model="loading">
      <c-loading></c-loading>
    </v-dialog>

    <v-dialog v-if="navDrawer" :scrollable="true" fullscreen v-model="navDrawer">
      <c-nav-drawer></c-nav-drawer>
    </v-dialog>

    <v-dialog v-if="searchbar" :scrollable="true" persistent v-model="searchbar">
      <c-searchbar></c-searchbar>
    </v-dialog>

  </div>
</template>

<script>
import authPerimeter from '../../perimeters/auth';

export default {
  data: function(){
    return {

    }
  },

  computed: {
    addBook: {
      get(){return this.$store.state.modal.modals.addBook;}
    },

    addSection: {
      get(){return this.$store.state.modal.modals.addSection;}
    },

    addHadith: {
      get(){return this.$store.state.modal.modals.addHadith;}
    },

    addAuthor: {
      get(){return this.$store.state.modal.modals.addAuthor;}
    },

    addHadithComment: {
      get(){return this.$store.state.modal.modals.addHadithComment;}
    },

    addCommentary: {
      get(){return this.$store.state.modal.modals.addCommentary;}
    },

    addCommentator: {
      get(){return this.$store.state.modal.modals.addCommentator;}
    },

    addNarrator: {
      get(){return this.$store.state.modal.modals.addNarrator;}
    },

    addLink: {
      get(){return this.$store.state.modal.modals.addLink;}
    },

    addBio: {
      get(){return this.$store.state.modal.modals.addBio;}
    },

    addBioAuthor: {
      get(){return this.$store.state.modal.modals.addBioAuthor;}
    },

    addBioBook: {
      get(){return this.$store.state.modal.modals.addBioBook;}
    },

    linkHadith: {
      get(){return this.$store.state.modal.modals.linkHadith;}
    },

    addLanguage: {
      get(){return this.$store.state.modal.modals.addLanguage;}
    },

    addTranslation: {
      get(){return this.$store.state.modal.modals.addTranslation;}
    },

    register: {
      get(){return this.$store.state.modal.modals.register;}
    },

    login: {
      get(){return this.$store.state.modal.modals.login;}
    },

    loading: {
      get(){return this.$store.state.modal.modals.loading;}
    },

    navDrawer: {
      get(){return this.$store.state.modal.modals.navDrawer;}
    },

    searchbar: {
      get(){return this.$store.state.modal.modals.searchbar;}
    },

  },

  mounted: function(){

  },

  methods: {

  },

  perimeters: [
    authPerimeter,
  ],
}


</script>

<style>


</style>
