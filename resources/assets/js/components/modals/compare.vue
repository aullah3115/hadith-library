<template>
  <v-card>
    <v-card-text>
      <v-toolbar color="primary">
        <v-toolbar-title>Comparison of these two ahaadith</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon small @click.prevent="hide('compare')"><v-icon small>close</v-icon></v-btn>
      </v-toolbar>

      <v-card-text>
        <span v-for="object in change_objects">

        <span v-if="object.removed">
          <span>--</span><span class="removed">{{object.value}} </span>
        </span>

        <span v-else-if="object.added">
          <span>++</span><span class="added">{{object.value}} </span>
        </span>

        <span v-else>
          <span class="same">{{object.value}} </span>
        </span>

      </span>

      <v-divider></v-divider>
      <v-list>
        <v-list-tile>Blue = found in both hadith</v-list-tile>
        <v-list-tile>Red = missing in second hadith</v-list-tile>
        <v-list-tile>Green = present in second hadith</v-list-tile>
      </v-list>
      </v-card-text>
      
    </v-card-text>
  </v-card>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  data: function(){
    return {
      change_objects: null,
    }
  },

  computed: {
    hadith: {
      get(){return this.$store.state.hadith.hadith;}
    },
    related_hadith: {
      get(){return this.$store.state.hadith.related_hadith;}
    }
  },

  mounted: function(){
    this.change_objects = diff.diffWords(this.hadith.body, this.related_hadith.body);
  },

  methods: {
    
    hide: function(modal){
      
      this.$store.dispatch('modal/hide', modal);
    },
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>

.removed {
  color: red;
}

.added {
  color: darkgreen;
}

.same {
  color: blue;
}
</style>
