<template>
  <v-card>
    <v-toolbar class="toolbar" card dark color="primary">
      <v-toolbar-title>Add a new biography for {{narrator.used_name}}</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon dark @click.native="hide('addBio')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>
    </v-toolbar>

    <v-card-text>
      <v-form @submit.prevent="addBio">
        <v-stepper v-model="step" vertical>

          <v-stepper-step :complete="step > 1" step="1">
            Select a source
          </v-stepper-step>

          <v-stepper-content  step="1">

            <v-card>
              <v-card-text>
                <div v-if="books">

                  <v-select
                          v-model="book"
                          item-text="name"
                          :items="books"
                          return-object
                          label="Select Source"
                          target="#dropdown-example"
                          autocomplete
                        ></v-select>

                    <p>
                      OR
                    </p>
                </div>

                <v-btn flat color="primary" @click.native="show('addBioBook')">Add a new source</v-btn>
              </v-card-text>
            </v-card>


            <v-btn :disabled="!book" color="primary" flat @click.native="step = 2">Next</v-btn>

          </v-stepper-content>

          <v-stepper-step :complete="step > 2" step="2">
            Enter the biography text
          </v-stepper-step>

          <v-stepper-content step="2">
            <v-card>
              <v-card-text>
                <v-text-field name="text" label="Biography text" v-model="text" textarea rows="5" light></v-text-field>
              </v-card-text>

            </v-card>

              <v-btn color="primary" flat @click.native="step = 1">Back</v-btn>
              <v-btn :disabled="!text" color="primary" flat @click.native="step = 3">Next</v-btn>
          </v-stepper-content>

          <v-stepper-step step="3">
            Verify and submit form
          </v-stepper-step>

          <v-stepper-content  step="3">

            <v-card>
              <v-card-text>
                <p v-if="book">
                  Source: {{book.name}}
                </p>
                <p>
                  Text: {{text}}
                </p>
              </v-card-text>
            </v-card>

            <v-btn color="primary" flat @click.native="step = 2">Back</v-btn>
            <v-btn flat color="primary" type="submit">Submit</v-btn>
          </v-stepper-content>

        </v-stepper>
      </v-form>

    </v-card-text>
  </v-card>
</template>

<script>
import authPerimeter from '../../perimeters/auth';

export default {
  data: function(){
    return {
      step: 1,
      book: '',
      text: '',
    }
  },

  computed: {
    narrator: {
       get(){return this.$store.state.narrator.narrator;}
    },
    books: {
      get(){return this.$store.state.bio_book.books;}
    }
  },

  mounted: function(){
    this.getBooks();
  },

  methods: {
    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    },

    show: function(modal) {
      this.$store.dispatch('modal/show', modal);

    },

    getBooks: function(){
      this.$store.dispatch('bio_book/getAll');
    },

    addBio: function(){

      let data = {
        'narrator_id': this.narrator.id,
        'bio_book_id': this.book.id,
        'text': this.text,
      }
      this.$store.dispatch('bio/addBio', data);
    }
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style>


</style>
