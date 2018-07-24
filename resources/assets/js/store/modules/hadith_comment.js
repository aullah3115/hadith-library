/**
 * This is the ... module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {
    comments: null,
    comment: null,
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

    removeComment(state){
      state.comment = null;
      state.comment_text = null;
    },

    storeComment(state, comment){
      state.comment = comment;
    },

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

    unselectComment: function({commit}){
      commit('removeComment');
    },

    selectComment: function({commit}, comment){

      axios.get('/vue/text/for/hadith/comment/' + comment.id)
      .then( ({data}) => {
        comment.text = data.text;
        commit('storeComment', comment);
      })
    },
  },
}
