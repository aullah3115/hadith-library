<template>
  <div>


    <!--router-link :to="{ name: 'books', params: {} }">View our collection of books</router-link-->
    <v-jumbotron>
      <h1 class="text-xs-center">Welcome to the Library</h1>
      <div class="text-xs-center">
        <h3>Hadith Library is a community-contributed database of ahaadith.
          The app allows users to view in depth information on each hadith.
          We hope it will be beneficial to scholars, students, and lay people also.</h3>
          <br />
          <v-divider></v-divider>
          <h2>View our collection of books</h2>
        <v-btn large color="primary" :to="{ name: 'books', params: {} }">{{$t('message.click_here')}}</v-btn>
        <br /><br />
        <v-divider></v-divider>
        <h2 class="">Find out more about the site</h2>
        <v-btn large color="primary" :to="{ name: 'about', params: {} }">{{$t('message.click_here')}}</v-btn>

      </div>

    </v-jumbotron>



      <!--router-link :to="{ name: 'books', params: {} }">
        <button>
          View our collection of books
        </button>
      </router-link-->


  </div>
</template>

<script>
import authPerimeter from '@/acl/perimeters/auth';

export default {
  methods: {

  },

  perimeters: [
    authPerimeter
  ]
}


</script>

<style scoped>

button {
  text-transform: uppercase;
  background-color: #0056b3;
  height: 45px;
  border-radius: 5px;
  padding: 0px 30px 0px;

}

button:hover {
  background-color: blue;
}

a {
  text-decoration: none;
  color: white;
  margin: 0px;
}

</style>
