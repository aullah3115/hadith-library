export default {
  storeLanguages(state, languages){
    state.languages = languages;
  },

  addLanguage(state, language){
    if(!state.languages){
      state.languages = [];
    }
    state.languages.push(language);
  },
  toggleDrawer(state){
    state.drawer = !state.drawer;
  },
  storeSearchResults(state, results){
    state.search_results = results;
  },

}
