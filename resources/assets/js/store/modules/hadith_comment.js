/**
 * This is the ... module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {
    hadith_id: null,
    comments: null,
    related_comments: null,
    comment: null,
    related_comment: null,
    related_comments_loading: null,
  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {
    addComment(state, comment){
      if(!state.comments){
        state.comments = [];
      }
      state.comments.push(comment);
    },

    storeComments(state, comments){
      state.comments = comments;
    },

    storeRelatedComments(state, comments){
      state.related_comments = comments;
    },

    removeRelatedComments(state){
      state.related_comments = null;
    },

    removeComment(state){
      state.comment = null;
    },

    removeRelatedComment(state){
      state.related_comment = null;
    },

    storeComment(state, comment){
      state.comment = comment;
    },

    storeRelatedComment(state, comment){
      state.related_comment = comment;
    },

    storeHadithId(state, id){
      state.hadith_id =id;
    }

  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {

    addComment: function({dispatch, state, commit}, data){
      axios.post('/vue/hadith_comment/create', data)
      .then( ({data}) => {
        dispatch('modal/hide', 'addHadithComment', {root: true});
        commit('addComment', data.comment);
      })
      .catch( (response) => {
        //TODO
      })
    },

    getComments: function({dispatch, state, commit}, hadith_id){

      axios.get('/vue/comments/for/hadith/' + hadith_id)
      .then( ({data}) => {

        commit('storeComments', data.comments);
      })
      .catch( (response) => {
        //TODO
      });
    },

    getRelatedComments: function({dispatch, state, commit}, data){

      if(state.hadith_id && state.hadith_id == data.hadith_id){
        return;
      }
      
      commit('removeRelatedComment');
      commit('removeRelatedComments');
      commit('storeHadithId', data.hadith_id);

      axios.post('/vue/related/comments', data.related_ids)
      .then( ({data}) => {
        console.log(data); 
        commit('storeRelatedComments', data.comments);
      })
      .catch( (response) => {
        //TODO
      });
    },

    unselectComment: function({commit}){
      commit('removeComment');
    },

    unselectRelatedComment: function({commit}){
      commit('removeRelatedComment');
    },

    selectComment: function({commit}, comment){

      axios.get('/vue/text/for/hadith/comment/' + comment.id)
      .then( ({data}) => {
        comment.text = data.text;
        commit('storeComment', comment);
      })
    },

    selectRelatedComment: function({commit}, comment){

      axios.get('/vue/text/for/hadith/comment/' + comment.id)
      .then( ({data}) => {
        comment.text = data.text;
        commit('storeRelatedComment', comment);
      })
    },
  },
}
