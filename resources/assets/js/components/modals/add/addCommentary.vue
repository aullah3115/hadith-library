<template>

        <v-card>
          <v-toolbar card dark color="primary">
            <v-toolbar-title>Add a new commentary book</v-toolbar-title>

             <v-spacer></v-spacer>

             <v-toolbar-items>
               <v-btn icon dark @click.native="hide('addCommentary')">
                 <v-icon>close</v-icon>
               </v-btn>
             </v-toolbar-items>

          </v-toolbar>

          <v-card-text>
            <v-form @submit.prevent="addCommentary">
              <v-stepper v-model="step">

                <v-stepper-header>
                  <v-stepper-step :complete="step > 1" step="1">
                    Enter the name of the commentary book
                  </v-stepper-step>

                  <v-stepper-step :complete="step > 2" step="2">
                    Select the commentator
                  </v-stepper-step>

                  <v-stepper-step step="3">
                    Verify and submit form
                  </v-stepper-step>

                </v-stepper-header>

                <v-stepper-items>

                  <v-stepper-content step="1">
                    <v-card>
                      <v-card-text>
                        <v-text-field label="Name of Commentary" name="name" v-model="name" required></v-text-field>
                      </v-card-text>
                    </v-card>
                    <v-btn :disabled="!name" color="primary" flat @click.native="step = 2">Next</v-btn>
                  </v-stepper-content>

                  <v-stepper-content  step="2">
                    <v-card>
                      <v-card-text>
                        <div v-if="commentators">

                          <v-autocomplete
                                  v-model="commentator"
                                  item-text="used_name"
                                  :items="commentators"
                                  return-object
                                  label="Select Commentator"

                                ></v-autocomplete>

                            <p>
                              OR
                            </p>
                        </div>

                        <v-btn flat color="primary" @click.native="show('addCommentator')">Add a new commentator</v-btn>
                      </v-card-text>
                    </v-card>
                    <v-btn color="primary" flat @click.native="step = 1">Back</v-btn>
                    <v-btn :disabled="!commentator" color="primary" flat @click.native="step = 3">Next</v-btn>
                  </v-stepper-content>

                  <v-stepper-content  step="3">

                    <v-card>
                      <v-card-text>
                        <p>
                          Name: {{name}}
                        </p>
                        <p>
                          Commentary on: <span v-if="hadith">{{hadith.section.book.name}}</span>
                        </p>
                        <p>
                          Commentator: {{commentator.used_name}}
                        </p>
                      </v-card-text>
                    </v-card>

                    <v-btn color="primary" flat @click.native="step = 2">Back</v-btn>
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
      name: '',
      commentator: '',
      step: 1,

    }
  },

  computed: {
    commentators: {
      get(){return this.$store.state.commentator.commentators;}
    },

    hadith: {
      get(){return this.$store.state.hadith.hadith;}
    }
  },

  mounted: function(){
    this.getCommentators()
    this.getBooks();
  },

  methods: {
    getCommentators: function() {
      this.$store.dispatch('commentator/getAll');
    },

    getBooks: function(){
      this.$store.dispatch('book/getAll');
    },

    addCommentary: function(){

      let data = {
        commentator_id: this.commentator.id,
        book_id: this.hadith.section.book.id,
        name: this.name,
      };

      this.$store.dispatch('commentary/addCommentary', data);

    },

    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    }


  }, // end of methods

}


</script>

<style>


</style>
