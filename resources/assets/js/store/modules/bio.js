import Alert from '../../classes/alert';

/**
 * This is the ... module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {
    narrator_id: null,
    bios: null,
    selected_bio: null,
  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {
    storeBios(state, bios){
      state.bios = bios;
    },

    storeNarratorId(state, id){
      state.narrator_id = id;
    },

    addBio(state, bio){
      if(!state.bios){
        state.bios = [];
      }
      state.bios.push(bio);
    },

    selectBio(state, bio){
      state.selected_bio = bio;
    },

    unselectBio(state){
      state.selected_bio = null;
    }
  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {

    addBio: function({state, commit, dispatch}, data){
      axios.post('/vue/bio/create', data)
      .then( ({data}) => {
        Alert.dispatch('New biography added', 'success');
        dispatch('modal/hide', 'addBio', {root:true});
        commit('addBio', data.bio);
      })
      .catch( (response) => {
        
      })
    },

    getBios: function({dispatch, state, commit}, narrator_id){

      if(state.narrator_id == narrator_id){
        return;
      }

      axios.get('/vue/bios/for/narrator/' + narrator_id)
      .then( ({data}) => {

        commit('storeBios', data.bios);
        commit('storeNarratorId', narrator_id);
      })
      .catch( (response) => {
        //TODO
      });
    },

    selectBio: function ({dispatch, commit, state}, bio){


      axios.get('/vue/text/for/bio/' + bio.id)
      .then( ({data}) => {
        bio.text = data.text;
        commit('selectBio', bio);
      });

    },

    unselectBio: function ({dispatch, commit, state}){
      commit('unselectBio');
    },


  },
}
