<template>

  <v-card v-if="narrator">

    <v-card-text>

      <v-toolbar v-if="selected_bio">
        <v-toolbar-title>Biography from {{selected_bio.source.name}} for {{narrator.used_name}}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon @click.native="unselectBio">
          <v-icon>close</v-icon>
        </v-btn>
      </v-toolbar>

      <v-toolbar v-else>
        <v-toolbar-title>Biographies for {{narrator.used_name}}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>

          <v-btn color="yellow darken-3" v-if="$isAllowed('auth')" @click.native="show('addBio')">
            <v-icon>add</v-icon>
          </v-btn>
          <v-btn @click.native="unselectNarrator">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar-items>

      </v-toolbar>

      <v-card v-if="selected_bio">

        <v-card-text>
          {{selected_bio.text}}
        </v-card-text>
      </v-card>

      <v-card v-else>
        <v-card-text>
          <v-list v-if="bios">
            <div v-for="bio in bios">
              <v-list-tile @click.prevent='selectBio(bio)'>
                <v-list-tile-content>
                  <v-list-tile-title>
                    {{bio.source.name}}
                  </v-list-tile-title>

                </v-list-tile-content>
              </v-list-tile>

              <v-divider></v-divider>
            </div>
          </v-list>
        </v-card-text>
      </v-card>


    </v-card-text>

  </v-card>


  <v-card v-else height="100%">

      <v-card-text>
        <v-toolbar>
          <v-toolbar-title>Choose a narrator</v-toolbar-title>
        </v-toolbar>
        <c-chain></c-chain>
      </v-card-text>

  </v-card>


</template>

<script>
import authPerimeter from '../../perimeters/auth';

export default {
  data: function(){
    return {

    }
  },

  computed: {
    narrator: {
      get(){return this.$store.state.narrator.selected_narrator;}
    },
    bios: {
      get(){return this.$store.state.bio.bios;}
    },
    selected_bio: {
      get(){return this.$store.state.bio.selected_bio;}
    }
  },

  created: function(){

  },

  methods: {
    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    selectBio: function(bio){
      this.$store.dispatch('bio/selectBio', bio);
    },

    unselectBio: function(){
      this.$store.dispatch('bio/unselectBio');
    },

    unselectNarrator: function(){
      this.$store.dispatch('narrator/unselectNarrator');
    },
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>
.grid{
  display: grid;
  grid-template-columns: 25% 75%;
  grid-column-gap: 10px;
  grid-template-areas:
  "list bio";
  height: 400px;
  overflow-y: hidden;
}

.list {
  grid-area: list;
  overflow-y: auto;
}

.bio{
  grid-area: bio;
  overflow-y: auto;
}

.content{
  height: 100%;
  overflow: auto;
}

@media screen and (max-width: 800px) {
  .grid {
    height: auto;
    max-height: 400px;
  }
}

</style>
