<template>
  <div>
  <!--v-btn flat color="primary" @click.prevent="goBack()">Go back</v-btn-->
    <div v-if="book">
        <a @click="openBook(book.id)"><h1 class="text-xs-center">{{book.name}}</h1></a>
    </div>

    <div v-if="parent && parent_id">
      <h3 class="text-xs-center">{{parent.name}}</h3>
    </div>

    <div class="main-grid">

      <mq-layout mq="lg+" class="book-list">
      <v-card>
        <v-toolbar color="primary">
          <v-toolbar-title>{{$t('message.books')}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items class="mr-0">
            <v-btn icon small v-if="$isAllowed('auth')" @click.native="show('addBook')">
              <v-icon>add</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <c-book-list></c-book-list>
      </v-card>
      </mq-layout>

      <v-card class="grid" v-if="parent == null || (parent && parent.has_section)">


        <v-toolbar class="title" color="primary">
          <v-toolbar-title>{{$t('message.sections')}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items class="mr-0">
            <v-btn icon small v-if="$isAllowed('auth')" @click.native="show('addSection')">
              <v-icon>add</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>



        <v-card-text class="body">
          <v-list v-if="sections" two-line>
            <div v-for="section in sections" :key="section.id">
              <v-list-tile>
                <v-list-tile-content class="section_name" @click.prevent="openSection(section.id)">
                  <v-list-tile-title>
                    {{section.position}} {{section.name}}
                  </v-list-tile-title>


                </v-list-tile-content>
                <v-list-tile-action v-if="$isAllowed('auth')">

                    <v-btn icon small @click.prevent="editSection(section)"><v-icon small>edit</v-icon></v-btn>
                    <!--v-btn flat color="info">Delete - TODO</v-btn-->

                </v-list-tile-action>

              </v-list-tile>



              <v-divider></v-divider>
            </div>
          </v-list>
        </v-card-text>


      </v-card>


      <v-card class="grid" v-if="parent && parent.has_hadith">
        <v-toolbar class="title" color="primary">
          <v-toolbar-title>{{$t('message.ahaadith_in_chapter')}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items class="mr-0">
            <v-btn icon small v-if="$isAllowed('auth')" @click.stop="show('addHadith')">
              <v-icon>add</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>



        <v-card-text class="body">
          <c-hadith-list :parent_id="parent_id"></c-hadith-list>
        </v-card-text>

      </v-card>




    </div>


  </div>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  props: {
    book_id: [String, Number],
    parent_id: [String, Number],

  },

  data: function(){
    return {
      step: 1,
      bookName: "",
      //parent_id: this.parent_id_prop,
      //book_id: this.book_id_prop,
    }
  },

  computed: {
    sections(){
        return this.$store.state.section.sections;
    },

    hadiths(){
        return this.$store.state.hadith.hadiths;
    },

    parent: {
      get(){
          return this.$store.state.section.parent;
      }
    },
    p_id(){
    //  return this.parent_id_prop;
    },


    book: {
      get(){return this.$store.state.book.book;}
    }
  },

  created: function(){
    this.loadPage();
  },

  watch: {
    '$route': 'loadPage',
  },

  methods: {

    loadPage: function(){
      //this.setProps();
      this.getSections();
      this.getBook();
      this.getParent();
    },

    getSections: function(parent_id = this.parent_id) {

      let data = {
        book_id: this.book_id,
        parent_id: parent_id,
      };


      this.$store.dispatch('section/getSections', data);
    },




    getBook: function(){
      if(this.book_id){
        this.$store.dispatch('book/getBook', this.book_id);
      }
    },

    setProps(){
      //  this.parent_id = this.parent_id_prop;
      //  this.book_id = this.book_id_prop;
    },

    getParent: function(){

        this.$store.dispatch('section/getParent', this.parent_id);


    },

    show: function(modal) {
      this.$store.dispatch('modal/show', modal);
    },

    hide: function(modal) {
      this.$store.dispatch('modal/hide', modal);
    },


    openSection: function(id){
      
        this.$router.push({name: 'openSection', params: {parent_id: id}});
    
    },

    editSection: function(section){
      
      this.$store.dispatch('section/storeSection', section);
      this.show('editSection');

    },

    openHadith: function(id){

        this.$router.push({name: 'hadith', params: {hadith_id: id}});

    },
    openBook: function(id){

      this.$router.push({name: 'openBook', params: {book_id: id}, parent_id: null });
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
  grid-template-columns: 100%;
  grid-template-rows: 48px 400px;
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

@media screen and (min-width: 800px){
  .main-grid{
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-column-gap: 10px;
    grid-template-areas:
    "book-list sections sections sections";
  }

  .book-list{
    grid-area: book-list;
  }

  .grid{
    grid-area: sections;
  }
}

</style>
