<template>
  <v-app>
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
import NavBar from "~/components/NavBar.vue";

export default {
    components: { NavBar },
    data(){
      return{
        fixed: false,
      }
    },
}
</script>
