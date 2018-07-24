<template>
  <v-card>
    <v-toolbar class="toolbar" card color="primary">
      <v-toolbar-title>
        Narrations of <span v-if="student">{{student.used_name}}</span> from <span v-if="teacher">{{teacher.used_name}}</span>
      </v-toolbar-title>

       <v-spacer></v-spacer>

         <v-btn icon small @click.native="hide('displayNarrations')">
           <v-icon small>close</v-icon>
         </v-btn>

    </v-toolbar>

    <v-card-text>
      <v-list v-if="narrations" three-line>
        <div v-for="narration in narrations">
          <v-list-tile @click.prevent="openHadith(narration.id)">
            <v-list-tile-content>
              <v-list-tile-title>Source: {{narration.book}}</v-list-tile-title>
              <v-list-tile-sub-title>{{narration.blurb}}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
        </div>
      </v-list>
    </v-card-text>
  </v-card>



</template>

<script>
export default {

  data: function(){
    return {
      name: '',
      direction: '',

      //narrator: '',
    }
  },

  computed: {
    student: {
      get(){return this.$store.state.narrator.selected_student;}
    },

    teacher: {
      get(){return this.$store.state.narrator.selected_teacher;}
    },

    narrations: {
      get(){return this.$store.state.narrator.narrations;}
    },
  },

  mounted: function(){

  },

  methods: {

    hide: function(modal){
      this.$store.dispatch('modal/hide', modal);
    },

    openHadith: function(id){
      this.hide('displayNarrations');
      this.$router.push({name: 'hadith', params: {hadith_id: id}});
    },

  },

}


</script>

<style>


</style>
