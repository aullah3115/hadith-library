/**
 * This is the ... module.
 */

export default {

    namespaced: true,
  
    /**
     * Data for this module
     */
  
    state: {
        search_results: null, 
        search_terms: [],
        hadiths: null,
        commentaries: null,
        bios: null,
        narrators: null,
    },
  
    /**
     * Mutations for this module. This are used to commit changes to the module
     * state.
     */
  
    mutations: {
        storeSearchResults(state, results){
            state.search_results = results;
          },

          groupResults(state, results){
            let hadiths = [];
            let commentaries = [];
            let narrators = [];
            let bios = [];
        
            for(var i = 0; i < results.length; i++){
                
                let index = results[i]._index;
               
                switch (index) {
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

            state.hadiths = hadiths;
            state.commentaries = commentaries;
            state.bios = bios;
            state.narrators = narrators;
          },
        /*
        storeSearchResultsGrouped(state, results){
            state.search_results_grouped = results;
        },
        */
        storeSearchTerms(state, terms){
            state.search_terms = terms;
        },
    },

    getters: {
        
    },
  
    /**
     * Actions for this module. These are asynchronus and are used for ajax
     * calls, as well as to trigger mutations
     */
  
    actions: {
        submitQuery: ({commit}, data) => {
            let terms = data.query.split(" ");
            commit('storeSearchTerms', terms);
            axios.post('/vue/search', data)
            .then( ({data}) => {
              commit('storeSearchResults', data.results);
              commit('groupResults', data.results);
      
            })
          },  
  
    },
  }
  