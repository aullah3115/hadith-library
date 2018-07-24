<template>
  <v-card class="grid">
    <v-toolbar class="toolbar" card color="admin">
      <v-toolbar-title>Add a new role</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon @click.native="hide('addRole')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>

    </v-toolbar>

    <v-card-text class="body">
      
        <v-stepper v-model="step">

          <v-stepper-header>
            <v-stepper-step :complete="step > 1" step="1">
              Enter the name of the role
            </v-stepper-step>

            <v-stepper-step :complete="step > 2" step="2">
              Assign permissions
            </v-stepper-step>

            <v-stepper-step step="3">
              Verify and submit form
            </v-stepper-step>

          </v-stepper-header>

          <v-stepper-items>
            <v-stepper-content  step="1">

              <v-card>
                <v-card-text>
                  <v-text-field label="Name of new role" name="name" v-model="name" required></v-text-field>

                </v-card-text>
              </v-card>
              <v-btn :disabled="!name" color="admin" flat @click.native="step=2">Next</v-btn>
            </v-stepper-content>

            <v-stepper-content  step="2">

              <v-card>
                <v-card-text>
                  <div v-if="permissions">
                    <div v-for="permission in permissions" :key="permission.id">
                        <v-checkbox v-model="selected_permissions" :label="permission.name" :value="permission.name"></v-checkbox>
                    </div>
                    
                      <p>
                        OR
                      </p>
                  </div>

                  <v-btn flat color="admin" @click.native="show('addPermission')">Add a new permission</v-btn>
                </v-card-text>
              </v-card>

              <v-btn color="admin" flat @click.native="step = 1">Back</v-btn>
              <v-btn color="admin" flat @click.native="step = 3">Next</v-btn>

            </v-stepper-content>

            <v-stepper-content  step="3">
              <v-form @submit.prevent="addRole">
              <v-card>
                <v-card-text>
                  <p>
                    Name: {{name}}
                  </p>
                  <p>
                    Permissions: {{permissions}}
                  </p>
                </v-card-text>
              </v-card>

              <v-btn color="admin" flat @click.native="step = 2">Back</v-btn>
              <v-btn flat color="admin" type="submit">Submit</v-btn>
              </v-form>
            </v-stepper-content>
          </v-stepper-items>

        </v-stepper>

      



    </v-card-text>
  </v-card>



</template>

<script>
export default {
  data: function(){
    return {
      name: '',
      selected_permissions: [],
      step: 1,

    }
  },

  computed: {
    permissions: {
        get(){return this.$store.state.admin.permissions;}
    }

  },

  mounted: function(){
    this.getPermissions()
  },

  methods: {
    getPermissions: function() {
      this.$store.dispatch('admin/getPermissions');// TODO
    },

    addRole: function(){

      let data = {
        name: this.name,
        permissions: this.selected_permissions,
      };

      //console.log(data);

      this.$store.dispatch('admin/addRole', data); //TODO

    },

    show: function(modal){
      this.$store.dispatch('modal/show', modal);
    },

    hide: function(modal){
      this.step = 1;
      this.clearForm();
      this.$store.dispatch('modal/hide', modal);
    },

    clearForm: function(){
      this.name = '';
      this.selected_permissions = [];
    }


  }, // end of methods

}


</script>

<style scoped>
.grid {
  display: grid;
  grid-template-rows: 64px auto;
  grid-template-areas:
  "toolbar"
  "body";
}

.toolbar{
  grid-area: toolbar;
}

.body{
  grid-area: body;
}

</style>
