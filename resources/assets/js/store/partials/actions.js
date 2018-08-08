export default {
  addLanguage: ({commit, dispatch}, name) => {
    axios.post('/vue/language/create', name)
    .then( ({data}) => {
      commit('addLanguage', data.language);
    });
  },

  getLanguages: ({commit, dispatch}) => {
    axios.get('/vue/languages')
    .then( ({data}) => {
      commit('storeLanguages', data.languages);
    })
  },

  toggleDrawer: ({commit}) => {
    commit('toggleDrawer');
  },

  submitContactForm: function( {commit, state, dispatch}, data){
    axios.post('/vue/submit/contact/form', data)
    .then( ({data}) => {
        console.log(data);
    })
  },

  getMessages: function( {commit, state, dispatch}){
    axios.get('/vue/messages')
    .then( ({data}) => {
      console.log(data);
      commit('storeMessages', data.messages);
    })
  },

  toggleDirectory: ({commit}, value) => {
    commit('toggleDirectory', value);
  },

}
