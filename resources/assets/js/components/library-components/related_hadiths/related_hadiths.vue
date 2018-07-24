<template>
  <div>
  <!--v-btn flat color="primary" @click.prevent="goBack()">Go back</v-btn-->
  <v-list three-line>
    <div v-for="hadith in hadiths" :key="hadith.id">


      <v-list-tile @click="openHadith(hadith.id)">
        <v-list-tile-content>
          <v-list-tile-title>

            Hadith number: {{hadith.number}}

          </v-list-tile-title>

          <v-list-tile-sub-title >
             {{hadith.blurb}}
          </v-list-tile-sub-title>


        </v-list-tile-content>

      </v-list-tile>

      <v-divider></v-divider>
    </div>
  </v-list>


  </div>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  props: {
    parent_id: {
      type: [Number, String]

    },
  },

  data: function(){
    return {

    }
  },

  computed: {


   hadiths(){

             let linked_hadiths = this.$store.state.hadith.linked_hadiths;
             if(!linked_hadiths){
               return null;
             }

             let related_hadiths = this.$store.state.hadith.related_hadiths;
             let current = this.$store.state.hadith.hadith;
             //related_hadiths.push(current);
             let filtered = linked_hadiths.filter( (l_hadith) => {

               let exists = related_hadiths.findIndex( (r_hadith) => {
                 return l_hadith.id == r_hadith.id;
               });

               if(exists == -1 && (l_hadith.id != current.id)){
                 return true;
               }

               return false;
             });

             return filtered.map( (hadith) => {


                  hadith.blurb = hadith.blurb.length > 100 ? hadith.blurb.substring(0, 100) + '...' : hadith.blurb;

               return hadith;
             });
    },





  },

  mounted: function(){
    //console.log(this.book_id + '/' + this.parent_id);
    this.getHadiths();
  },

  watch: {
    //'$route': 'getHadiths',
  },

  methods: {



    getHadiths: function() {

        this.$store.dispatch('hadith/getLinkedHadiths', this.parent_id)

    },



    openHadith: function(hadith_id){

      this.$store.dispatch('hadith/getLinkedHadith', hadith_id)
    },

  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>


</style>
