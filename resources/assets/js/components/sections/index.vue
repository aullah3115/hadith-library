<template>
  <div>
  <!--v-btn flat color="primary" @click.prevent="goBack()">Go back</v-btn-->
    <div v-if="book">
        <a @click="openBook(book.id)"><h1 class="text-md-center">{{book.name}}</h1></a>
    </div>

    <div v-if="parent && parent_id">
      <h3 class="text-md-center">{{parent.name}}</h3>
    </div>

    <div>

      <v-card class="grid" v-if="parent == null || (parent && parent.has_section)">


        <v-toolbar class="title" color="blue darken-1">
          <v-toolbar-title class="white--text">Sections</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items class="mr-0">
            <v-btn class="yellow--text text--lighten-5" depressed color="yellow darken-3" small v-if="$isAllowed('auth')" @click.native="show('addSection')">
              Add new Section
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>



        <v-card-text class="body">
          <v-list v-if="sections" two-line>
            <div v-for="section in sections">
              <v-list-tile>
                <v-list-tile-content class="section_name" @click.prevent="openSection(section.id)">
                  <v-list-tile-title>
                    {{section.position}} {{section.name}}
                  </v-list-tile-title>


                </v-list-tile-content>
                <v-list-tile-action>

                    <v-btn v-if="$isAllowed('auth')" flat color="info">Edit - TODO</v-btn>
                    <v-btn v-if="$isAllowed('auth')" flat color="info">Delete - TODO</v-btn>

                </v-list-tile-action>

              </v-list-tile>



              <v-divider></v-divider>
            </div>
          </v-list>
        </v-card-text>


      </v-card>


      <v-card class="grid" v-if="parent && parent.has_hadith">
        <v-toolbar class="title" color="blue darken-1">
          <v-toolbar-title class="white--text">Ahaadith</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items class="mr-0">
            <v-btn class="yellow--text text--lighten-5" depressed color="yellow darken-3" small v-if="$isAllowed('auth')" @click.stop="show('addHadith')">
              Add new Hadith
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>



        <v-card-text class="body">
          <c-hadith-list :parent_id="p_id"></c-hadith-list>
        </v-card-text>

      </v-card>




    </div>


  </div>
</template>

<script>
import authPerimeter from '../../perimeters/auth';

export default {
  props: {
    book_id_prop: [String, Number],
    parent_id_prop: [String, Number],
    complete: {
      type: Boolean,
      default: false,
    }
  },

  data: function(){
    return {
      step: 1,
      bookName: "",
      parent_id: this.parent_id_prop,
      book_id: this.book_id_prop,
    }
  },

  computed: {
    sections(){
      if(this.complete){
        return this.$store.state.section.sections;
      }
      return this.$store.state.section.linked_sections;
    },



    parent: {

      get(){
        if(this.complete){
          return this.$store.state.section.parent;
        }
        return this.$store.state.section.linked_parent;
      }
    },
    p_id(){
      return this.parent_id_prop;
    },

    /*
    showAddHadith: {
      get(){return this.$store.state.modal.modals.addHadith;}
    },

    message: {
      get(){return this.$store.state.book.message;}
    },

    showAddSection: {
      get(){return this.$store.state.modal.modals.addSection;}
    },
    */



    book: {
      get(){return this.$store.state.book.book;}
    }
  },

  created: function(){
    //console.log(this.book_id + '/' + this.parent_id);
    this.loadPage();
  },

  watch: {
    '$route': 'loadPage',
  },

  methods: {

    loadPage: function(){
      this.setProps();
      this.getSections();
      //this.getHadith();
      this.getBook();
      this.getParent();
    },

    getSections: function(parent_id = this.parent_id) {

      let data = {
        book_id: this.book_id,
        parent_id: parent_id,
        complete: this.complete,
      };


      this.$store.dispatch('section/getSections', data);
    },




    getBook: function(){
      if(this.book_id){
        this.$store.dispatch('book/getBook', this.book_id);
      }
    },

    setProps(){
        this.parent_id = this.parent_id_prop;
        this.book_id = this.book_id_prop;
    },

    getParent: function(parent_id = this.parent_id){
        let data = {
          parent_id: parent_id,
          complete: this.complete,
        }
        this.$store.dispatch('section/getParent', data);


    },

    show: function(modal) {
      this.$store.dispatch('modal/show', modal);
    },

    hide: function(modal) {
      this.$store.dispatch('modal/hide', modal);
    },

    goBack: function(){
      this.$router.go(-1);
    },

    openSection: function(id){
      //console.log(id);
      if(this.complete){
        this.$router.push('/sections/section/' + id);
      } else{
        //this.setProps();
        this.book_id = null;
        this.parent_id = id;
        this.getSections(id);
        //this.getHadith(id);
        this.getParent(id);
      }

    },

    openHadith: function(id){
      if(this.complete){
        this.$router.push('/hadiths/hadith/' + id);
        return;
      }
      let data = {
        hadith_id: id,
        complete: false,
      }
      this.$store.dispatch('hadith/getHadith', data)
    },
    openBook: function(id){

      this.$router.push('/books/book/' + id);
    }
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>
.grid {

  display: grid;
  grid-template-rows: 64px 400px;
  grid-template-areas:
  "title"
  "body";
  overflow-y: hidden;
}

.title{
  grid-area: title;
}

.body{
  grid-area: body;
  overflow-y: auto;

}

.section_name{
  color: #3E2723;
  cursor: pointer;
}

.section_name:hover {
  background-color: #E3F2FD;
}

</style>
