<template>
  <div>
  <!--v-btn flat color="primary" @click.prevent="goBack()">Go back</v-btn-->
    <div v-if="book">

        <h3 class="text-md-center">{{book.name}}</h3>

    </div>

    <div v-if="parent && parent_id">
      <h3 class="text-md-center">{{parent.name}}</h3>
    </div>

    <div>

      <v-card v-if="parent == null || (parent && parent.has_section)">

        <v-card-text>
          <v-list v-if="sections" two-line>
            <div v-for="section in sections" :key="section.id">
              <v-list-tile>
                <v-list-tile-content class="section_name" @click.prevent="openSection(section.id)">
                  <v-list-tile-title>
                    {{section.position}} {{section.name}}
                  </v-list-tile-title>


                </v-list-tile-content>


              </v-list-tile>



              <v-divider></v-divider>
            </div>
          </v-list>
        </v-card-text>


      </v-card>


      <v-card v-if="parent && parent.has_hadith">

        <v-card-text>
          <c-linked-hadith-list :parent_id="parent_id"></c-linked-hadith-list>
        </v-card-text>

      </v-card>




    </div>


  </div>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  props: {
    book_id_prop: [String, Number],
    parent_id_prop: [String, Number],

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
      return this.$store.state.section.linked_sections;
    },

    parent: {
      get(){return this.$store.state.section.linked_parent;}
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
      get(){return this.$store.state.book.linked_book;}
    }
  },

  mounted: function(){
    //console.log(this.book_id + '/' + this.parent_id);
    this.loadPage();
  },

  watch: {

  },

  methods: {

    loadPage: function(){

      this.getSections();
      //this.getHadith();
      this.getBook();
      this.getParent();
    },

    getSections: function() {

      let data = {
        parent_id: this.parent_id,
        book_id: this.book_id,
      };
      this.$store.dispatch('section/getLinkedSections', data);
    },




    getBook: function(){
      if(this.book_id){
        this.$store.dispatch('book/getLinkedBook', this.book_id);
      }
    },

    getParent: function(){
        console.log(this.parent_id);
        this.$store.dispatch('section/getLinkedParent', this.parent_id);


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

        //this.setProps();
        this.book_id = null;
        this.parent_id = id;
        this.getSections(id);
        //this.getHadith(id);
        this.getParent(id);


    },

    openHadith: function(id){

      let data = {
        hadith_id: id,
        complete: false,
      }
      this.$store.dispatch('hadith/getLinkedHadith', data)
    },

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
