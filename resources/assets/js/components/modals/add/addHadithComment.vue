<template>
  <v-card>
    <v-toolbar class="toolbar" card color="primary">
      <v-toolbar-title>Add new commenatry for this hadith</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon @click.native="hide('addHadithComment')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>

    </v-toolbar>





        <v-stepper v-model="step" class="overflow">
          <v-stepper-header>
            <v-stepper-step :complete="step > 1" step="1">
              Select the source of the commentary
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
              <v-card>
                <v-card-text>
                  <div v-if="commentaries">

                    <v-autocomplete
                            v-model="commentary"
                            item-text="name"
                            :items="commentaries"
                            return-object
                            label="Select Commentary"
                          ></v-autocomplete>

                      <p>
                        OR
                      </p>
                  </div>
                  <v-btn flat v-if="$isAllowed('auth')" color="primary" @click.prevent="show('addCommentary')">Add a new Commentary Book</v-btn>
                  <span v-if="hadith">Use this to add a commentary for {{hadith.section.book.name}}</span>
                </v-card-text>
              </v-card>
              <v-btn :disabled="!commentary" color="primary" flat @click.native="step=2">Next</v-btn>
            </v-stepper-content>

            <v-stepper-content step="2">
              <v-card>
                <v-card-text>
                  <v-textarea name="text" label="Commentary text" v-model="text" rows="3" light></v-textarea>
                </v-card-text>
              </v-card>
              <v-btn color="primary" flat @click.native="step=1">Back</v-btn>
              <v-btn :disabled="!text" color="primary" flat @click.native="step=3">Next</v-btn>
            </v-stepper-content>

            <v-stepper-content step="3">

                <v-card>
                  <v-card-text>
                    <v-form @submit.prevent="addHadithComment">
                      <p>
                        Add commentary for hadith number <span v-if="hadith">{{hadith.number}}</span>,
                        in section <span v-if="hadith">{{hadith.section.name}}</span>
                        of <span v-if="hadith">{{hadith.section.book.name}}</span>,
                        from <span v-if="commentaries">{{commentary.name}}</span>.
                      </p>
                      <p>
                        {{text | shorten(200)}}
                      </p>




                      <v-btn color="primary" flat @click.native="step=2">Back</v-btn>
                      <v-btn flat color="primary" type="submit">Submit</v-btn>
                    </v-form>
                  </v-card-text>
                </v-card>

            </v-stepper-content>

          </v-stepper-items>

        </v-stepper>



  </v-card>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  data: function(){
    return {
      step: 1,
      commentary: '',
      text: '',
    }
  },

  computed: {
    hadith(){
      return this.$store.state.hadith.hadith;
    },
    commentaries: {
      get(){return this.$store.state.commentary.commentaries;}
    }
  },

  created: function(){

      //console.log(this.$store.state.hadith.hadith.book.name)
      this.$store.dispatch('commentary/getForBook', this.$store.state.hadith.hadith.section.book.id);


  },

  methods: {
    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    },

    show: function(modal) {
      this.$store.dispatch('modal/show', modal);

    },

    addHadithComment: function(){
      let data = {
        hadith_id: this.$store.state.hadith.hadith.id,
        commentary_id: this.commentary.id,
        text: this.text,
        book: this.commentary.name,
      }
    
      this.$store.dispatch('hadith_comment/addComment', data);
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

  perimeters: [
    authPerimeter,
  ],

}

</script>

<style scoped>

.overflow {
  overflow-y: auto;
  max-height: 100%;
}
</style>
