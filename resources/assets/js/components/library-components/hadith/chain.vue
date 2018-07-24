<template>

    <v-list>
      <div v-for="link in chain" :key="link.id">
        <v-list-tile @click.prevent="selectNarrator(link)">
          <v-list-tile-content>
            {{link.chain.position}}. {{link.used_name}}
          </v-list-tile-content>
        </v-list-tile>
        <v-divider></v-divider>
      </div>

    </v-list>

</template>

<script>
export default {
  props: [
    //'hadith_id'
  ],
  data: function(){
    return {

    }
  },

  computed: {
    chain(){
      return this.$store.state.hadith.chain;
    },
    hadith_id: function(){
      return this.$route.params.hadith_id;
    }
  },

  mounted: function(){
    this.getChain();
  },

  methods: {
    getChain: function(){
      this.$store.dispatch('hadith/getChain', this.hadith_id);
    },

    selectNarrator: function(narrator){
      this.$router.push({name: 'narrator', params:{narrator_id: narrator.id}})
      return;
      this.$store.commit('hadith/select_tab', 3);
      this.$store.commit('hadith/select_panel', 3);
      this.$scrollTo('#narrators');
      this.$store.dispatch('bio/unselectBio');
      this.$store.dispatch('narrator/selectNarrator', narrator);
      this.$store.dispatch('bio/getBios', narrator.id);

    },

  },

}


</script>

<style>


</style>
