export default {
  addLanguage: ({commit, dispatch}, name) => {
    axios.post('/vue/language/create', name)
    .then( ({data}) => {
      console.log(data);
      commit('addLanguage', data.language);
    });
  },

  getLanguages: ({commit, dispatch}) => {
    axios.get('/vue/languages')
    .then( ({data}) => {
      console.log(data);
      commit('storeLanguages', data.languages);
    })
  },

  toggleDrawer: ({commit}) => {
    commit('toggleDrawer');
  },

  submitQuery: ({commit}, data) => {
    axios.post('/vue/search', data)
    .then( ({data}) => {
      commit('storeSearchResults', data.results);
      //console.log(data.results);
    })
  }
}
