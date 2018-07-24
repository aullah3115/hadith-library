<template>
    <div>
        <h1>Welcome to the super-admin panel</h1>

        <v-card>
          
          
        </v-card>

        <v-card>
          <v-toolbar color="admin"><v-toolbar-title>Users</v-toolbar-title></v-toolbar>

          <v-list v-if="users">
            <div v-for="user in users" :key="user.id">
              <v-list-tile @click="getUserRoles(user)">
                {{user.name}}
              </v-list-tile>
            </div>
          </v-list>
        </v-card>

        <v-card v-if="user">
          <v-toolbar color="admin"><v-toolbar-title>{{user.name}}</v-toolbar-title></v-toolbar>

          <v-list v-if="user_roles">
            <div v-for="role in user_roles" :key="role.id">
              <v-list-tile>
                {{role.name}}
              </v-list-tile>
            </div>
          </v-list>
        </v-card>
        

        <v-card>
          <v-toolbar color="admin">
            <v-toolbar-title>Roles</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn small icon @click="show('addRole')"><v-icon small>add</v-icon></v-btn>
          </v-toolbar>

          <v-list v-if="roles">
            <div v-for="role in roles" :key="role.id">
              <v-list-tile @click="getRolePermissions(role)">
                {{role.name}}
              </v-list-tile>
            </div>
          </v-list>
        </v-card>

        <v-card v-if="role">
          <v-toolbar color="admin"><v-toolbar-title>{{role.name}}</v-toolbar-title></v-toolbar>

          <v-list v-if="role_permissions">
            <div v-for="permission in role_permissions" :key="permission.id">
              <v-list-tile>
                {{permission.name}}
              </v-list-tile>
            </div>
          </v-list>
        </v-card>

        

        <v-card>
          <v-toolbar color="admin">
            <v-toolbar-title>Permissions</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon small @click="show('addPermission')"><v-icon small>add</v-icon></v-btn>
          </v-toolbar>

          <v-list v-if="permissions">
            <div v-for="permission in permissions" :key="permission.id">
              <v-list-tile>
                {{permission.name}}
              </v-list-tile>
            </div>
          </v-list>
        </v-card>

        
        
    </div>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  data: function(){
    return {

    }
  },

  computed: {

    user: {
      get(){return this.$store.state.admin.user;},
    },

    user_roles: {
      get(){return this.$store.state.admin.user_roles;},
    },

    role: {
      get(){return this.$store.state.admin.role;},
    },

    role_permissions: {
      get(){return this.$store.state.admin.role_permissions;},
    },

    users: {
      get(){return this.$store.state.admin.users;},
    },

    roles: {
      get(){return this.$store.state.admin.roles;},
    },

    permissions: {
      get(){return this.$store.state.admin.permissions;},
    },
  },

  mounted: function(){
    this.getAllUsers();
    this.getPermissions();
    this.getRoles();
  },

  methods: {
    getAllUsers: function(){
      this.$store.dispatch('admin/getAllUsers');
    },

    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    getPermissions: function(){
      this.$store.dispatch('admin/getPermissions');
    },

    getRoles: function(){
      this.$store.dispatch('admin/getRoles');
    },

    getUserRoles: function(user){
      this.$store.dispatch('admin/getUserRoles', user);
    },

    getRolePermissions: function(role){
      this.$store.dispatch('admin/getRolePermissions', role);
    },    
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style>


</style>
