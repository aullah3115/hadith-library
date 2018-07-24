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

  submitQuery: ({commit}, data) => {
    let terms = data.query.split(" ");
    commit('storeSearchTerms', terms);
    axios.post('/vue/search', data)
    .then( ({data}) => {
      commit('storeSearchResults', data.results);
      let hadiths = [];
      let commentaries = [];
      let narrators = [];
      let bios = [];

      for(var i = 0; i < data.results.length; i++){
        let results = data.results;
        switch (results[i]._index) {
          case 'hadith':
            hadiths.push(results[i]);
            break;
          case 'commentary':
            commentaries.push(results[i]);
            break;
          case 'narrator':
            narrators.push(results[i]);
            break;
          case 'bio':
            bios.push(results[i]);
            break;
          default:
        }
      }

      let results = {
        hadiths,
        commentaries,
        narrators,
        bios,
      }

      commit('storeSearchResults1', results);
    })
  }
}
