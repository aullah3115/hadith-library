<template>

  <v-card v-if="links">
    <v-toolbar card color="primary">
      <v-toolbar-title>Add a new link to the chain</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon dark @click.native="hide('addLink')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>

    </v-toolbar>

    <v-card-text class="grid">

        <v-card class="chain">
          <v-card-text>
            <h3>Text of the chain:</h3>
            <p>
               {{chain}}
            </p>

            <h3>
              Links already added:
            </h3>

            <p v-for="link in links" :key="link.chain.position">
              <span>{{link.chain.position}} {{link.used_name}}</span>
            </p>
          </v-card-text>
        </v-card>




        <div class="addLink">
          <v-card height="400px" class="v-card">
            <v-card-text>
              <v-form @submit.prevent="addLink()">




                        <div v-if="narrators">

                          <h3>
                            Add a narrator at position {{links.length + 1}} in the chain
                          </h3>

                          <v-autocomplete
                                  v-model="narrator"
                                  item-text="used_name"
                                  :items="narrators"
                                  return-object
                                  label="Select Narrator"
                                  target="#dropdown-example"
                                ></v-autocomplete>

                                <p>
                                  OR
                                </p>

                          </div>
                          <v-btn flat color="primary" @click.native="show('addNarrator')">Add a new narrator</v-btn>
                    <v-divider></v-divider>

                    <v-btn type="submit" flat color="primary">Submit</v-btn>
              </v-form>
            </v-card-text>
          </v-card>
        </div>


    </v-card-text>


  </v-card>

</template>

<script>
export default {
  props: [
    //'hadith_id',
  ],
  data: function(){
    return {
      narrator: '',
      step: 1,
    }
  },

  computed: {
    hadith_id(){
      return this.$route.params.hadith_id;
    },

    narrators(){
      return this.$store.state.narrator.narrators;
    },
    chain(){
      return this.$store.state.hadith.hadith.chain;
    },
    links(){
      return this.$store.state.hadith.chain;
    }
  },

  mounted: function(){
    this.getNarrators();
  },

  methods: {
    getNarrators: function(){
      this.$store.dispatch('narrator/getAll');
    },

    addLink: function(){
      let data = {hadith_id: this.hadith_id, position: (this.links.length + 1), narrator_id: this.narrator.id};
      console.log(data);
      this.$store.dispatch('hadith/addLink', data);
    },

    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    },
  },

}


</script>

<style scoped>
.grid{
  display: grid;
  grid-template-columns: 25% auto;
  grid-column-gap: 0px;
  grid-template-areas:
  "chain addLink";


}

.chain{
  grid-area: chain;
  overflow-y: auto;
  height: auto;

}

.addLink{
  grid-area: addLink;
  height: 100%;
  overflow-y: auto;
  height: 400px;

}

@media screen and (max-width: 800px) {
  .grid {
    display: grid;
    grid-template-columns: 100%;
    grid-template-rows: auto;;
    grid-row-gap: 15px;
    grid-template-areas:
    "chain"
    "addLink";
    overflow: hidden;
  }

  .chain{
    grid-area: chain;
    overflow-y: auto;
    height: auto;
    max-height: 200px;
  }

  .addLink{
    grid-area: addLink;
    height: 100%;
    overflow-y: auto;
    height: auto;

  }


}

</style>
