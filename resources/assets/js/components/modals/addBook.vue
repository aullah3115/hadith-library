<template>
  <v-card class="grid">
    <v-toolbar class="toolbar" card dark color="primary">
      <v-toolbar-title>Add a new hadith collection</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon dark @click.native="hide('addBook')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>

    </v-toolbar>

    <v-card-text class="body">
      <v-form @submit.prevent="addBook">
        <v-stepper v-model="step" vertical>

          <v-stepper-step :complete="step > 1" step="1">
            Enter the name of the collection
          </v-stepper-step>

          <v-stepper-content  step="1">

            <v-card>
              <v-card-text>
                <v-text-field label="Name of Hadith Collection" name="name" v-model="name" required></v-text-field>

              </v-card-text>
            </v-card>
            <v-btn :disabled="!name" color="primary" flat @click.native="step=2">Next</v-btn>
          </v-stepper-content>

          <v-stepper-step :complete="step > 2" step="2">
            Select an author
          </v-stepper-step>

          <v-stepper-content  step="2">

            <v-card>
              <v-card-text>
                <div v-if="authors">

                  <v-select
                          v-model="author"
                          item-text="used_name"
                          :items="authors"
                          return-object
                          label="Select Author"
                          target="#dropdown-example"
                          autocomplete
                        ></v-select>

                    <p>
                      OR
                    </p>
                </div>

                <v-btn flat color="primary" @click.native="show('addAuthor')">Add a new author</v-btn>
              </v-card-text>
            </v-card>

            <v-btn color="primary" flat @click.native="step = 1">Back</v-btn>
            <v-btn :disabled="!author" color="primary" flat @click.native="step = 3">Next</v-btn>

          </v-stepper-content>

          <v-stepper-step step="3">
            Verify and submit form
          </v-stepper-step>

          <v-stepper-content  step="3">

            <v-card>
              <v-card-text>
                <p>
                  Name: {{name}}
                </p>
                <p>
                  Author: {{author.used_name}}
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
export default {
  data: function(){
    return {
      name: '',
      author: '',
      step: 1,

    }
  },

  computed: {
    authors: {
      get(){return this.$store.state.author.authors;}
    },

  },

  mounted: function(){
    this.getAuthors()
  },

  methods: {
    getAuthors: function() {
      this.$store.dispatch('author/getAll');
    },

    addBook: function(){

      let data = {
        author_id: this.author.id,
        author_neo_id: this.author.neo_id,
        name: this.name,
      };

      //console.log(data);

      this.$store.dispatch('book/addBook', data);

    },

    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    hide: function(modal){
      this.step = 1;
      this.clearForm();
      this.$store.dispatch('modal/hide', modal);
    },

    clearForm: function(){
      this.name = '';
      this.author = '';
    }


  }, // end of methods

}


</script>

<style scoped>
.grid {
  display: grid;
  grid-template-rows: 64px auto;
  grid-template-areas:
  "toolbar"
  "body";
}

.toolbar{
  grid-area: toolbar;
}

.body{
  grid-area: body;
}

</style>
