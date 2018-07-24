<template>
  <v-card>
    <v-toolbar class="toolbar" card color="primary">
      <v-toolbar-title>Add a new biography for {{narrator.used_name}}</v-toolbar-title>

       <v-spacer></v-spacer>


         <v-btn icon small @click.native="hide('addBio')">
           <v-icon>close</v-icon>
         </v-btn>

    </v-toolbar>

    <v-card-text>
      <v-form @submit.prevent="addBio">
        <v-stepper v-model="step">

          <v-stepper-header>

            <v-stepper-step :complete="step > 1" step="1"></v-stepper-step>

            <v-stepper-step :complete="step > 2" step="2"></v-stepper-step>

            <v-stepper-step step="3"></v-stepper-step>

          </v-stepper-header>

          <v-stepper-items>

            <v-stepper-content  step="1">

                <div v-if="books">

                  <v-autocomplete
                          v-model="book"
                          item-text="name"
                          :items="books"
                          return-object
                          label="Select Source"
                          target="#dropdown-example"
                        ></v-autocomplete>

                    <p>
                      OR
                    </p>
                </div>

                <v-btn flat color="primary" @click.native="show('addBioBook')">Add a new source</v-btn>

              <v-divider></v-divider>

              <v-btn :disabled="!book" color="primary" flat @click.native="step = 2">Next</v-btn>

            </v-stepper-content>

            <v-stepper-content step="2">

                <v-textarea name="text" label="Biography text" v-model="text" rows="5"></v-textarea>

                <v-divider></v-divider>
                <v-btn color="primary" flat @click.native="step = 1">Back</v-btn>
                <v-btn :disabled="!text" color="primary" flat @click.native="step = 3">Next</v-btn>
            </v-stepper-content>

            <v-stepper-content  step="3">
                  <p v-if="book">
                    Source: {{book.name}}
                  </p>
                  <p>
                    Text: {{text}}
                  </p>

                  <v-divider></v-divider>
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
        narrator_id: this.narrator.id,
        bio_book_id: this.book.id,
        text: this.text,
        narrator: this.narrator.used_name,
        book: this.book.name,

      }
      this.$store.dispatch('bio/addBio', data);
    }
  },

}


</script>

<style>


</style>
