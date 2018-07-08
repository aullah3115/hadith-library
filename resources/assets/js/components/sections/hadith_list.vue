<template>
  <div>
  <!--v-btn flat color="primary" @click.prevent="goBack()">Go back</v-btn-->
  <v-list three-line>
    <div v-for="hadith in hadiths">


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
import authPerimeter from '../../perimeters/auth';

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

     let hadiths = this.$store.state.hadith.hadiths
     if(!hadiths){return null;}
     hadiths = hadiths.map( (hadith) => {


          hadith.blurb = hadith.blurb.length > 50 ? hadith.blurb.substring(0, 100) + '...' : hadith.blurb;

       return hadith;
     });
     return hadiths;
    },



  },

  created: function(){
    //console.log(this.book_id + '/' + this.parent_id);
    this.getHadiths();
  },

  watch: {
    //'$route': 'getHadiths',
  },

  methods: {



    getHadiths: function() {

        this.$store.dispatch('hadith/getHadiths', this.parent_id)

    },



    openHadith: function(id){

        this.$router.push('/hadiths/hadith/' + id);
        return;

    },

  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>


</style>
