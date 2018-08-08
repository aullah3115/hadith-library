<template>
    <div>
        <v-card>
            <v-list v-if="messages">
                <v-list-group v-for="message in messages" :key="message.id">
                    <v-list-tile slot="activator">
                        <v-list-tile-content>
                            <v-list-tile-title>{{message.email}}</v-list-tile-title>
                        </v-list-tile-content>                  
                    </v-list-tile>
                    <v-card>
                        <v-card-text>{{message.message}}</v-card-text>
                    </v-card>
                </v-list-group>
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
      messages: {
          get(){return this.$store.state.messages;}
      }
  },

  mounted: function(){
      this.getMessages();
  },

  methods: {
      getMessages: function(){
          this.$store.dispatch('getMessages');
      }
  },

  perimeters: [
    authPerimeter,
  ],

}


</script>

<style>


</style>
