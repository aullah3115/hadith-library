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
        <v-list-group v-for="narration in narrations" :key="narration.id">
          <v-list-tile slot="activator">
            <v-list-tile-content>
              <v-list-tile-title>Source: {{narration.book}}</v-list-tile-title>
              <v-list-tile-sub-title>Section: {{narration.section}}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>

          <v-card>
            <v-card-text>
            {{narration.body}}
            </v-card-text>
            <v-btn color="primary" @click="openHadith(narration.id)">Go to hadith</v-btn>
          </v-card>
        </v-list-group>
          
       
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

    hadith: {
      get(){return this.$store.state.narrator.narration;}
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
