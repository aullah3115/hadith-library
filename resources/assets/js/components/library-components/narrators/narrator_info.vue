<template>
  <div>
    <h1 v-if="narrator" class="text-xs-center">{{narrator.used_name}}</h1>

    <v-expansion-panel focusable popout>
      <v-expansion-panel-content>
        <div slot="header">Biographies</div>

        <v-card v-if="narrator">
    
          </v-toolbar>

          <v-card-text>
            <c-hadith-narrators></c-hadith-narrators>
          </v-card-text>
        </v-card>

      </v-expansion-panel-content>

      <v-expansion-panel-content v-if="narrations">
        <div slot="header">All narrations</div>
        <v-list three-line>
          <v-divider></v-divider>
          <div v-for="narration in narrations">
            <v-list-tile @click.prevent="openHadith(narration.id)">
              <v-list-tile-content>
                <v-list-tile-title>
                  Source: {{narration.book}}
                </v-list-tile-title>

                <v-list-tile-sub-title>{{narration.blurb | truncate(100)}}</v-list-tile-sub-title>

              </v-list-tile-content>
              <v-list-tile-action>
                <v-list-tile-action-text>Click to view</v-list-tile-action-text>
              </v-list-tile-action>
            </v-list-tile>

            <v-divider></v-divider>
          </div>
        </v-list>
      </v-expansion-panel-content>

      <v-expansion-panel-content v-if="teachers && teachers.length > 0">
        <div slot="header">Narrated from...</div>

        <v-list>
          <v-divider></v-divider>
          <div v-for="teacher in teachers">
            <v-list-tile @click.prevent="getTeacherNarrations(teacher)">
              <v-list-tile-content>
                <v-list-tile-title>
                  {{teacher.used_name}}
                </v-list-tile-title>

              </v-list-tile-content>
              <v-list-tile-action>
                <v-list-tile-action-text>Click to view narrations</v-list-tile-action-text>
              </v-list-tile-action>

            </v-list-tile>

            <v-divider></v-divider>
          </div>
        </v-list>
      </v-expansion-panel-content>

      <v-expansion-panel-content v-if="students && students.length > 0">
        <div slot="header">Narrated to...</div>
        <v-list>
          <v-divider></v-divider>
          <div v-for="student in students">
            <v-list-tile @click.prevent="getStudentNarrations(student)">
              <v-list-tile-content>
                <v-list-tile-title>
                  {{student.used_name}}
                </v-list-tile-title>

              </v-list-tile-content>
              <v-list-tile-action>
                <v-list-tile-action-text>Click to view narrations</v-list-tile-action-text>
              </v-list-tile-action>
            </v-list-tile>

            <v-divider></v-divider>
          </div>
        </v-list>
      </v-expansion-panel-content>

    </v-expansion-panel>

  </div>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  props: [
    'narrator_id',
  ],
  data: function(){
    return {

    }
  },

  computed: {
    narrator: {
      get(){return this.$store.state.narrator.narrator;}
    },
    bios: {
      get(){return this.$store.state.bio.bios;}
    },
    teachers: {
      get(){return this.$store.state.narrator.teachers;}
    },
    students: {
      get(){return this.$store.state.narrator.students;}
    },

    narrations: {
      get(){return this.$store.state.narrator.all_narrations;}
    },

  },

  created: function(){
    this.getNarrator();
    this.getBios();
    this.getTeachers();
    this.getStudents();
    this.getAllNarrations();
  },

  methods: {
    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    getNarrator: function(){
        this.$store.dispatch('narrator/getNarratorById', this.narrator_id)
    },

    getBios: function(){
      this.$store.dispatch('bio/getBios', this.narrator_id)
    },

    getTeachers: function(){
      this.$store.dispatch('narrator/getTeachers', this.narrator_id);
    },

    getStudents: function(){
      this.$store.dispatch('narrator/getStudents', this.narrator_id);
    },

    getTeacherNarrations: function(teacher){
      let data = {
        student: this.narrator,
        teacher: teacher,
      }
      this.$store.dispatch('narrator/getNarrations', data);
      this.show('displayNarrations');
    },

    getStudentNarrations: function(student){
      let data = {
        student: student,
        teacher: this.narrator,
      }
      this.$store.dispatch('narrator/getNarrations', data);
      this.show('displayNarrations');
    },

    getAllNarrations: function(){
      this.$store.dispatch('narrator/getAllNarrations', this.narrator_id)
    },

    openHadith: function(id){
      this.$router.push({name: 'hadith', params: {hadith_id: id}});
    },

  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style>


</style>
