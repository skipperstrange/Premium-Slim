<template>
    <div  v-if="isAuthenticated">
        <v-navigation-drawer
      v-model="drawer"
      :mini-variant="miniVariant"
      :clipped="clipped"
      fixed
      app
    >
      <v-list>
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          :to="item.to"
          router
          exact
        >
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="item.title" />
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar
      absolute
      color="primary"
      dark
      :clipped-left="clipped"
      fixed
      app
      elevation="3"
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title v-text="title" />
      <v-spacer />

      <v-spacer></v-spacer>

      <v-btn icon title="Logout" @click="logout()">
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </v-app-bar>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    name: "NavBar",
     data () {
    return {
      clipped: false,
      drawer: false,
      fixed:false,
      user: {},
      items: [
        {
          icon: 'mdi-apps',
          title: 'Quote Requests',
          to: '/'
        }
        ,{
          icon: 'mdi-account',
          title: 'Users',
          to: '/users'
        }
      ],
      miniVariant: false,
      right: true,
      rightDrawer: false,
      title: 'Admin'
    }
  },
  computed: {
    ...mapGetters(['isAuthenticated','loggedInUser'])
  },
  mounted() {
      console.log(this.loggedInUser)
      // this.user = this.loggedInUser
      // this.title = this.user.first_name+' '+this.user.last_name
  },
  methods:{
      async logout(){
          await this.$auth.logout()
              console.log('Logging out..')
            this.$router.push('/auth/login')
      }
  }
}
</script>