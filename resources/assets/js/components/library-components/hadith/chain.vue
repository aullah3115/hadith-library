<template>

    <v-list>
      <div v-for="link in chain" :key="link.id">
        <v-list-tile>
          <v-list-tile-content>
            {{link.chain.position}}. {{link.used_name}}
          </v-list-tile-content>
          <v-list-tile-action>
            <v-btn flat color="primary" @click.prevent="open(link.id)">Open</v-btn>
          </v-list-tile-action>
        </v-list-tile>
        <v-divider></v-divider>
      </div>

    </v-list>

</template>

<script>
export default {
  props: {
    hadithId: {
      default: null,
    },
    compare: {
      default: false,
    }
  },
  data: function(){
    return {

    }
  },

  computed: {
    chain(){
      if(this.compare){
        return this.$store.state.hadith.related_chain;
      }
      return this.$store.state.hadith.chain;
    },
    hadith_id: function(){
      if(this.hadithId){
        return this.hadithId;
      }
      return this.$route.params.hadith_id;
    }
  },

  mounted: function(){
    this.getChain();
  },

  watch: {
    '$route': 'getChain',
  },

  methods: {
    getChain: function(){
      if(this.compare){
        this.$store.dispatch('hadith/getRelatedChain', this.hadith_id);
        return;
      }
      this.$store.dispatch('hadith/getChain', this.hadith_id);
    },

    open: function(id){
      if(this.hadithId){
        return;
      }
      this.$router.push({name: 'narrator', params:{narrator_id: id}})
      return;
      /*
      this.$store.commit('hadith/select_tab', 3);
      this.$store.commit('hadith/select_panel', 3);
      this.$scrollTo('#narrators');
      this.$store.dispatch('bio/unselectBio');
      this.$store.dispatch('narrator/selectNarrator', narrator);
      this.$store.dispatch('bio/getBios', narrator.id);
    */
    },

  },

}


</script>

<style>


</style>
