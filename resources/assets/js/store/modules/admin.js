/**
 * This is the ... module.
 */

export default {

  namespaced: true,

  /**
   * Data for this module
   */

  state: {
      users: null,
      permissions: null,
      roles: null,
      user: null,
      user_roles: null,
      role: null,
      role_permissions: null,
  },

  /**
   * Mutations for this module. This are used to commit changes to the module
   * state.
   */

  mutations: {
      storeAllUsers(state, users){
          state.users = users;
      },

      storeRoles(state, roles){
          state.roles = roles;
      },

      storePermissions(state, permissions){
          state.permissions = permissions;
      },

      storeUser(state, user){
        state.user = user;
      },

      storeUserRoles(state, roles){
        state.user_roles = roles;
      },

      storeRole(state, role){
        state.role = role;
      },

      storeRolePermissions(state, permissions){
        state.role_permissions = permissions;
      },

      addRole(state, role){
          if(!state.roles){
              state.roles = [];
          }

          state.roles.push(role)
      },

      addPermission(state, permission){
        if(!state.permissions){
            state.permissions = [];
        }

        state.permissions.push(permission)
    },
  },

  /**
   * Actions for this module. These are asynchronus and are used for ajax
   * calls, as well as to trigger mutations
   */

  actions: {

      getAllUsers: function( {commit, state, dispatch}) {
          
          axios.get('/vue/users')
          .then( ({data}) => {
              commit('storeAllUsers', data.users);
          })
      },

      getUserRoles: function({commit, state, dispatch}, user){
        axios.get('/vue/roles/for/user/' + user.id)
        .then( ({data}) => {
            commit('storeUser', user);
            commit('storeUserRoles', data.roles);
        })
      },

      getRoles: function( {commit, state, dispatch}) {
          
          axios.get('/vue/roles')
          .then( ({data}) => {
              commit('storeRoles', data.roles);
          })
      },

      getRolePermissions: function({commit, state, dispatch}, role){
        axios.get('/vue/permissions/for/role/' + role.id)
        .then( ({data}) => {
            commit('storeRole', role);
            commit('storeRolePermissions', data.permissions);
        })
      },

      getPermissions: function( {commit, state, dispatch}) {
          
          axios.get('/vue/permissions')
          .then( ({data}) => {
              commit('storePermissions', data.permissions);
          })
      },

      addRole: function( {commit, state, dispatch}, data) {
          
          axios.post('/vue/role', data)
          .then( ({data}) => {
              commit('addRole', data.role);
          })
      },

       addPermission: function( {commit, state, dispatch}, data) {
          
          axios.post('/vue/permission', data)
          .then( ({data}) => {
              commit('addPermission', data.permission);
          })
      },

      
  },
}
