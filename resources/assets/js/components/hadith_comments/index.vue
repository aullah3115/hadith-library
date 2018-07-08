<template>
  <v-card>


    <v-card-text  class="grid">

      <v-card v-if="comment" height="100%">
        <v-toolbar>
          <v-toolbar-title>Commentary from {{comment.commentary.name}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>

            <v-btn icon @click.native="unselectComment">
              <v-icon>close</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>

        <div class="content">
          <v-card-text v-if="comment_text">
            {{comment_text}}
          </v-card-text>
        </div>

      </v-card>

      <v-card class="content" v-else height="100%">
        <v-toolbar dense flat>
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
            <div v-for="comment in comments">
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
import authPerimeter from '../../perimeters/auth';

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
      get(){return this.$store.state.hadith_comment.comments;}
    },
    comment: {
      get(){return this.$store.state.hadith_comment.comment;}
    },
    comment_text: {
      get(){return this.$store.state.hadith_comment.comment_text;}
    },
  },

  created: function(){
    this.getComments();
  },

  mounted: function(){

  },

  methods: {
    getComments: function(){
      this.$store.dispatch('hadith_comment/getComments', this.hadith_id);
    },

    selectComment: function(comment){
      this.$store.dispatch('hadith_comment/selectComment', comment);
    },

    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    unselectComment: function(){
      this.$store.dispatch('hadith_comment/unselectComment');
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
