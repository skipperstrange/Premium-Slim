<template>
  <v-app>
      <div v-if="!isAuthenticated" class="hero"></div>
      <NavBar />
    <v-main>
      <v-container>
        <Nuxt />
      </v-container>
    </v-main>
    
    <v-footer
      :absolute="!fixed"
      app
    >
      <span>&copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
  </v-app>
</template>

<script>
import {mapGetters} from 'vuex'
import NavBar from "~/components/NavBar.vue";

export default {
    components: { NavBar },
    data(){
      return{
        fixed: false,
      }
    },
    computed: {
      ...mapGetters(['isAuthenticated','loggedInUser']) 
    },

}
</script>
