import Alert from '@/classes/alert';
import User from '../../classes/user';
/**
 * This is the Auth module. It contains details of the user as well as
 * methods to login and sign out.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {
    user: null,
  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {
    storeUser(state, user){

      state.user = user;

    },

    logout(state){
      state.user = null;

    },
  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {

    login: function({dispatch, commit}, user){


        axios.post('/vue/login', user)

            .then(({data}) => {
              let user = data.user;
              user.roles = data.roles;
              commit('storeUser', user);

              Alert.dispatch('Successfully logged in', 'success')

              dispatch('modal/hide', 'loading', {root: true});

            })

            .catch(({response}) => {

              Alert.dispatch(response.data.message, 'error');

              dispatch('modal/hide', 'loading', {root: true});
            });



    },

    logout: function({dispatch, commit}) {

      return new Promise(function(resolve, reject){

        axios.get('/vue/logout')
        .then(function(){

            commit('logout');
            Alert.dispatch('You have successfully signed out', 'success');
            dispatch('modal/hide', 'loading', {root: true});

        })

        .catch(({response}) => {

          Alert.dispatch(response.data.message, 'error');
          dispatch('modal/hide', 'loading', {root: true});


        });

        resolve()

      })

    },

    register: function({dispatch, commit}, data) {

      dispatch('modal/show', "loading", {root: true});
      dispatch('modal/setMessage', 'Attempting to create a new account...', {root: true})

      axios.post('/vue/register', data)
      .then( ({data}) => {

          commit('storeUser', data);
          Alert.dispatch('You have successfully created a new account', 'success');
          dispatch('modal/hide', "loading", {root: true});
          dispatch('modal/hide', "register", {root: true});

      })
      .catch( ({response}) => {

        Alert.dispatch(response.data.message, 'error');
        dispatch('modal/hide', "loading", {root: true});


        })

    },

    checkAuth: function(context) {

      axios.get('/vue/user')

      .then( ({data}) => {

        let user = data.user;
        user.roles = data.roles;

        context.commit('storeUser', user);

      })

      .catch ( ({resonse}) => {
      })

    },

  }
}
