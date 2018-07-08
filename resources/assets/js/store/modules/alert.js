/**
 * This is the Alert module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {

    type: "info",
    message: "",
    value: false,

  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {

    setAlert(state, data){
      state.type = data.type;
      state.message = data.message;
      state.value = true;
      setTimeout(function(){
      state.value = false;
      }, 3000)
    },

    dismiss(state) {
      state.type = "info";
      state.message = "";
      state.value = false;
    }

  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {

    setAlert: function(context, data){
      context.commit('setAlert', data);
    },

    dismiss: function(context, data) {
      context.commit('dismiss');
    }

  },
}
