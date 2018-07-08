<template>
  <div>


    <!--router-link :to="{ name: 'books', params: {} }">View our collection of books</router-link-->
    <v-jumbotron color="indigo darken-3">
      <h1 class="text-md-center white--text">Welcome to the Library</h1>
      <div class="text-xs-center">
        <h3 class="white--text">Hadith Library is a community-contributed database of ahaadith.
          The app allows users to view in depth information on each hadith.
          We hope it will be beneficial to scholars, students, and lay people also.</h3>
        <v-btn large color="primary" :to="{ name: 'books', params: {} }">View our collection of books</v-btn>
      </div>
      <div class="text-xs-center">
        <h3 class="white--text">To find out more about the site check out the following</h3>
        <v-btn large color="primary" :to="{ name: 'about', params: {} }">Find out more about the project</v-btn>
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
import authPerimeter from '../../perimeters/auth';

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
