<template>
  <v-card class="grid">
    <v-toolbar class="toolbar" card color="admin">
      <v-toolbar-title>Add a new permission</v-toolbar-title>

       <v-spacer></v-spacer>

       <v-toolbar-items>
         <v-btn icon @click.native="hide('addPermission')">
           <v-icon>close</v-icon>
         </v-btn>
       </v-toolbar-items>

    </v-toolbar>

    <v-card-text class="body">
      
        <v-stepper v-model="step">

          <v-stepper-header>
            <v-stepper-step :complete="step > 1" step="1">
              Enter the name of the permission
            </v-stepper-step>

            <v-stepper-step :complete="step > 2" step="2">
              Assign to roles
            </v-stepper-step>

            <v-stepper-step step="3">
              Verify and submit form
            </v-stepper-step>

          </v-stepper-header>

          <v-stepper-items>
            <v-stepper-content  step="1">

              <v-card>
                <v-card-text>
                  <v-text-field label="Name of new permission" name="name" v-model="name" required></v-text-field>

                </v-card-text>
              </v-card>
              <v-btn :disabled="!name" color="admin" flat @click.native="step=2">Next</v-btn>
            </v-stepper-content>

            <v-stepper-content  step="2">

              <v-card>
                <v-card-text>
                  <div v-if="roles">

                    <div v-for="role in roles" :key="role.id">
                        <v-checkbox v-model="selected_roles" :label="role.name" :value="role.name"></v-checkbox>
                    </div>

                      <p>
                        OR
                      </p>
                  </div>

                  <v-btn flat color="admin" @click.native="show('addRole')">Add a new role</v-btn>
                </v-card-text>
              </v-card>

              <v-btn color="admin" flat @click.native="step = 1">Back</v-btn>
              <v-btn color="admin" flat @click.native="step = 3">Next</v-btn>

            </v-stepper-content>

            <v-stepper-content  step="3">
              <v-form @submit.prevent="addPermission">
              <v-card>
                <v-card-text>
                  <p>
                    Name: {{name}}
                  </p>
                  <p>
                    Roles: TODO
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
      selected_roles: [],
      step: 1,

    }
  },

  computed: {
    roles: {
        get(){return this.$store.state.admin.roles;}
    }

  },

  mounted: function(){
    this.getRoles()
  },

  methods: {
    getRoles: function() {
      this.$store.dispatch('admin/getRoles');// TODO
    },

    addPermission: function(){

      let data = {
        name: this.name,
        roles: this.selected_roles,
      };

      //console.log(data);

      this.$store.dispatch('admin/addPermission', data); //TODO

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
      this.selected_roles = [];
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
