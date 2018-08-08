<template>
  <v-card>


    <v-card-text  class="grid">

      <v-card v-if="comment" height="100%">
        <v-toolbar color="primary">
          <v-toolbar-title>Commentary from {{comment.commentary.name}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>

            <v-btn icon @click.native="unselectComment">
              <v-icon>close</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>

        <div class="content">
          <v-card-text>
            <h3>Original hadith</h3>
            <p>{{comment.hadith.blurb}}</p>
            <p>Section: {{comment.hadith.section.name}} in Book: {{comment.hadith.section.book.name}}</p>
            <h3>Commentary</h3>
            {{comment.text}}
          </v-card-text>
        </div>

      </v-card>

      <v-card class="content" v-else height="100%">
        <v-toolbar dense flat color="primary">
          <v-toolbar-title>Select a commentary source</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn small icon v-if="$isAllowed('auth')" @click.native="show('addHadithComment')">
            <v-icon small>add</v-icon>
          </v-btn>
          <v-toolbar-items>

          </v-toolbar-items>

        </v-toolbar>
        <v-card-text>
          <v-list v-if="comments">
            <div v-for="comment in comments" :key="comment.id">
              <v-list-tile @click.prevent='selectComment(comment)'>
                <v-list-tile-content>
                  <v-list-tile-title>
                    {{comment.commentary.name}}
                  </v-list-tile-title>

                </v-list-tile-content>
              </v-list-tile>

              <v-divider></v-divider>
            </div>
          </v-list>
        </v-card-text>
      </v-card>





    </v-card-text>

  </v-card>

</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  props: [
    'hadith_id',
  ],
  data: function(){
    return {
      selected_comment: null,
    }
  },

  computed: {
    comments: {
      get(){return this.$store.state.hadith_comment.related_comments;}
    },
    comment: {
      get(){return this.$store.state.hadith_comment.related_comment;}
    },
    related_ids(){
      return this.$store.getters['hadith/related_hadith_ids'];
    },
  },
  
  watch:{
    related_ids: function(value){
      if(value){
        this.getRelatedComments();
      }
    },
    /*
    $route: function(to, from){
      this.unselectComment();
    },
    */
  },

  created: function(){
    //this.getRelatedComments();
  },

  mounted: function(){

  },

  methods: {
    getRelatedComments: function(){
      //console.log(this.related_ids);
      let data = {
        hadith_id: this.hadith_id,
        related_ids: this.related_ids,
      };
      this.$store.dispatch('hadith_comment/getRelatedComments', data);
    },

    selectComment: function(comment){
      this.$store.dispatch('hadith_comment/selectRelatedComment', comment);
    },

    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    unselectComment: function(){
      this.$store.dispatch('hadith_comment/unselectRelatedComment');
    },
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style scoped>
.grid{

  height: 400px;
  overflow-y: hidden;
}

.content {
  height: 100%;
  overflow: auto;
}

.comment{
  overflow-y: auto;
}

@media screen and (max-width: 800px) {
  .grid {
    height: auto;
    max-height: 400px;
  }
}

</style>
