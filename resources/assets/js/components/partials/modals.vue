<template>
  <div>

    <v-dialog v-if="addBook" :scrollable="true" fullscreen v-model="addBook">
      <c-add-book></c-add-book>
    </v-dialog>

    <v-dialog v-if="editBook" :scrollable="true" fullscreen v-model="editBook">
      <c-edit-book></c-edit-book>
    </v-dialog>

    <v-dialog v-if="addSection" :scrollable="true" fullscreen v-model="addSection">
      <c-add-section></c-add-section>
    </v-dialog>

    <v-dialog v-if="editSection" :scrollable="true" fullscreen v-model="editSection">
      <c-edit-section></c-edit-section>
    </v-dialog>

    <v-dialog v-if="addHadith" :scrollable="true" fullscreen v-model="addHadith">
      <c-add-hadith></c-add-hadith>
    </v-dialog>

    <v-dialog v-if="editHadith" :scrollable="true" fullscreen v-model="editHadith">
      <c-edit-hadith></c-edit-hadith>
    </v-dialog>

    <v-dialog v-if="addAuthor" :scrollable="true" fullscreen v-model="addAuthor">
      <c-add-author></c-add-author>
    </v-dialog>

    <v-dialog v-if="addHadithComment" :scrollable="true" fullscreen v-model="addHadithComment">
      <c-add-hadith-comment></c-add-hadith-comment>
    </v-dialog>

    <v-dialog v-if="addCommentary" :scrollable="true" fullscreen v-model="addCommentary">
      <c-add-commentary></c-add-commentary>
    </v-dialog>

    <v-dialog v-if="addCommentator" :scrollable="true" fullscreen v-model="addCommentator">
      <c-add-commentator></c-add-commentator>
    </v-dialog>

    <v-dialog v-if="addNarrator" :scrollable="true" fullscreen v-model="addNarrator">
      <c-add-narrator></c-add-narrator>
    </v-dialog>

    <v-dialog v-if="addLink" :scrollable="true" fullscreen v-model="addLink">
      <c-add-link></c-add-link>
    </v-dialog>

    <v-dialog v-if="addBio" :scrollable="true" fullscreen v-model="addBio">
      <c-add-bio></c-add-bio>
    </v-dialog>

    <v-dialog v-if="addBioAuthor" :scrollable="true" fullscreen v-model="addBioAuthor">
      <c-add-bio-author></c-add-bio-author>
    </v-dialog>

    <v-dialog v-if="addBioBook" :scrollable="true" fullscreen v-model="addBioBook">
      <c-add-bio-book></c-add-bio-book>
    </v-dialog>

    <v-dialog v-if="linkHadith" :scrollable="true" fullscreen v-model="linkHadith">
      <c-link-hadith></c-link-hadith>
    </v-dialog>

    <v-dialog v-if="addLanguage" :scrollable="true" fullscreen v-model="addLanguage">
      <c-add-language></c-add-language>
    </v-dialog>

    <v-dialog v-if="addTranslation" :scrollable="true" fullscreen v-model="addTranslation">
      <c-add-translation></c-add-translation>
    </v-dialog>

    <v-dialog :scrollable="true" v-model="login" fullscreen v-if="$isAllowed('guest') && login">
      <c-login></c-login>
    </v-dialog>

    <v-dialog :scrollable="true" v-model="register" fullscreen v-if="$isAllowed('guest') && register">
      <c-register></c-register>
    </v-dialog>

    <v-dialog v-if="loading" :scrollable="true" persistent v-model="loading">
      <c-loading></c-loading>
    </v-dialog>

    <v-dialog v-if="navDrawer" :scrollable="true" fullscreen v-model="navDrawer">
      <c-nav-drawer></c-nav-drawer>
    </v-dialog>

    <v-dialog v-if="searchbar" :scrollable="true" fullscreen v-model="searchbar">
      <c-searchbar></c-searchbar>
    </v-dialog>

    <v-dialog v-if="displayNarrations" :scrollable="true" fullscreen v-model="displayNarrations">
      <c-display-narrations></c-display-narrations>
    </v-dialog>

    <v-dialog v-if="compare" :scrollable="true" fullscreen v-model="compare">
      <c-compare-hadith></c-compare-hadith>
    </v-dialog>

    <v-dialog v-if="compareAll" :scrollable="true" fullscreen v-model="compareAll">
      <c-compare-all></c-compare-all>
    </v-dialog>

    <v-dialog v-if="contact" :scrollable="true" fullscreen v-model="contact">
      <c-contact-form></c-contact-form>
    </v-dialog>

    <!--Admin Modals-->
    <v-dialog v-if="addRole" :scrollable="true" fullscreen v-model="addRole">
      <c-add-role></c-add-role>
    </v-dialog>

    <v-dialog v-if="addPermission" :scrollable="true" fullscreen v-model="addPermission">
      <c-add-permission></c-add-permission>
    </v-dialog>

  </div>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  data: function(){
    return {

    }
  },

  computed: {
    addBook: {
      get(){return this.$store.state.modal.modals.addBook;}
    },

    editBook: {
      get(){return this.$store.state.modal.modals.editBook;}
    },

    addSection: {
      get(){return this.$store.state.modal.modals.addSection;}
    },

    editSection: {
      get(){return this.$store.state.modal.modals.editSection;}
    },

    addHadith: {
      get(){return this.$store.state.modal.modals.addHadith;}
    },

    editHadith: {
      get(){return this.$store.state.modal.modals.editHadith;}
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

    displayNarrations: {
      get(){return this.$store.state.modal.modals.displayNarrations;}
    },

    compare: {
      get(){return this.$store.state.modal.modals.compare;}
    },

    compareAll: {
      get(){return this.$store.state.modal.modals.compareAll;}
    },

    contact: {
      get(){return this.$store.state.modal.modals.contact;}
    },

    // Admin Modals

    addRole: {
      get(){return this.$store.state.modal.modals.addRole;}
    },

    addPermission: {
      get(){return this.$store.state.modal.modals.addPermission;}
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
