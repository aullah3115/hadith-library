<template>
  <v-card>
    <v-toolbar class="toolbar" card color="primary">
      <v-toolbar-title>Add a new translation for this hadith</v-toolbar-title>

       <v-spacer></v-spacer>

         <v-btn icon small @click.native="hide('addTranslation')">
           <v-icon small>close</v-icon>
         </v-btn>

    </v-toolbar>

    <v-card-text>

      <v-form @submit.prevent="addTranslation">

        <v-stepper v-model="step">

          <v-stepper-header>
            <v-stepper-step :complete="step > 1" step="1">
              Select language
            </v-stepper-step>

            <v-stepper-step :complete="step > 2" step="2">
              Enter the text of the commentary
            </v-stepper-step>

            <v-stepper-step step="3">
              Confirm and submit
            </v-stepper-step>
          </v-stepper-header>

          <v-stepper-items>
            <v-stepper-content step="1">


                  <div v-if="languages">

                    <v-autocomplete
                            v-model="language"
                            item-text="name"
                            :items="languages"
                            return-object
                            label="Select Language"
                            target="#dropdown-example"
                          ></v-autocomplete>

                      <p>
                        OR
                      </p>
                  </div>

                  <v-btn flat v-if="$isAllowed('auth')" color="primary" @click.prevent="show('addLanguage')">Add a new language</v-btn>
                  <v-divider></v-divider>
                  <v-btn :disabled="!language" color="primary" flat @click.native="step=2">Next</v-btn>



            </v-stepper-content>

            <v-stepper-content step="2">
              <h3>Hadith text</h3>
              <div class="grid">
                    <div class="hadith">

                      <p>{{hadith.body}}</p>
                    </div>

                    <div class="translation">
                      <v-textarea name="text" label="Enter translation here" v-model="text" rows="8" light></v-textarea>
                    </div>

              </div>

              <v-divider></v-divider>
              <v-btn color="primary" flat @click.native="step=1">Back</v-btn>
              <v-btn :disabled="!text" color="primary" flat @click.native="step=3">Next</v-btn>

            </v-stepper-content>

            <v-stepper-content step="3">
              <v-card>
                <v-card-text>
                  <p>
                    Add translation for hadith number <span v-if="hadith">{{hadith.number}}</span>,
                    in section <span v-if="hadith">{{hadith.section.name}}</span>
                    of <span v-if="hadith">{{hadith.section.book.name}}</span>,
                  </p>
                  <p>
                    {{text | shorten(1000)}}
                  </p>
                </v-card-text>
              </v-card>
              <v-btn color="primary" flat @click.native="step=2">Back</v-btn>
              <v-btn flat color="primary" type="submit">Submit</v-btn>
            </v-stepper-content>


          </v-stepper-items>

        </v-stepper>

      </v-form>

    </v-card-text>

  </v-card>
</template>

<script>
export default {
  data: function(){
    return {
      step: 1,
      language: '',
      text: '',
    }
  },

  computed: {
    hadith(){
      return this.$store.state.hadith.hadith;
    },
    languages: {
      get(){return this.$store.state.languages;}
    }
  },

  created: function(){

      //console.log(this.$store.state.hadith.hadith.book.name)
      //this.$store.dispatch('commentary/getForBook', this.$store.state.hadith.hadith.section.book.id);


  },

  methods: {
    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    },

    show: function(modal) {
      this.$store.dispatch('modal/show', modal);

    },

    addTranslation: function(){
      let data = {
        hadith_id: this.$store.state.hadith.hadith.id,
        language_id: this.language.id,
        text: this.text,
      }
      console.log(data);
      this.$store.dispatch('hadith_translation/addTranslation', data);
    }
  },

  filters: {
    shorten: function(text, length){
      if(text.length > length){
        let abbreviated = text.substring(0, length) + '...';
        return abbreviated;
      }
      return text;
    },
  },

}

</script>

<style scoped>
.grid{
  display: grid;
  grid-template-columns: 100%;
  grid-row-gap: 10px;
  grid-template-areas:
  "hadith"
  "translation";


}

.hadith{
  grid-area: hadith;
  overflow-y: auto;
  max-height: 120px;

}

.translation{
  grid-area: translation;
  height: auto;
  overflow-y: auto;

}

</style>
