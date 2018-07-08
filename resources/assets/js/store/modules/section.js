import Alert from '../../classes/alert';

/**
 * This is the Section module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {
    sections: null,
    linked_sections: null,
    parent: null,
    linked_parent: null,
  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {

    storeSections(state, sections){
      state.sections = sections;
    },

    storeLinkedSections(state, sections){
      state.linked_sections = sections;
    },

    storeParent(state, parent){
      state.parent = parent;
    },

    storeLinkedParent(state, parent){
      state.linked_parent = parent;
    },

    addSection(state, section){
      if(!state.sections){
        state.sections = [];
      }
      state.sections.push(section);
    },

    unselectLinkedSections(state){
      state.linked_sections = null;
      state.linked_parent = null;
    },

  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {

    getSections: ({commit, dispatch}, data) => {

      if(data.parent_id == null){
        data.parent_id = "";
      }

      axios.get('/vue/sections/' + data.book_id + '/' + data.parent_id )
      .then( ({data}) => {

          commit('storeSections', data.sections);

      })
      .catch(({response}) => {
        //$router.push('404');
      });

    },

    getLinkedSections: ({commit, dispatch}, data) => {

      if(data.parent_id == null){
        data.parent_id = "";
      }

      axios.get('/vue/sections/' + data.book_id + '/' + data.parent_id )
      .then( ({data}) => {

          commit('storeLinkedSections', data.sections);

      })
      .catch(({response}) => {
        //$router.push('404');
      });

    },

    getParent: ({commit, dispatch, state}, data) => {

      if(!data.parent_id){
          commit('storeParent', null);
          return;
      }

      axios.get('/vue/section/parent/' + data.parent_id )
      .then( ({data}) => {

          dispatch('book/storeBook', data.book, {root: true});
          commit('storeParent', data.parent);
          return;

      })
      .catch( ({response}) => {
        //TODO
      });
    },

    getLinkedParent: ({commit, dispatch, state}, parent_id) => {

      if(!parent_id){

        commit('storeLinkedParent', null);
        return;
      }

      axios.get('/vue/section/parent/' + parent_id )
      .then( ({data}) => {

        dispatch('book/storeLinkedBook', data.book, {root: true});
        commit('storeLinkedParent', data.parent);


      })
      .catch( ({response}) => {
        //TODO
      });
    },

    addSection: ({commit, dispatch}, data) => {

      axios.post('/vue/section/create', data)
      .then(({data}) => {

        commit('addSection', data.section);
        Alert.dispatch('Successfully added section', 'success');
      })
      .catch(({response}) => {
        Alert.dispatch(response.data.message, 'error');
      });
    },

    unselectLinkedSections: function({commit}){
      commit('unselectLinkedSections');
    }

  },
}
