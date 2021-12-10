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
            <v-list-item-title v-text="title" />
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
  <v-menu bottom left>
            <template v-slot:activator="{ on, attrs }">
              <v-btn dark icon v-bind="attrs" v-on="on">
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>

            <v-list>
              <v-list-item >
                <v-list-item-title @click="logout()">
                    <v-icon>mdi-logout</v-icon>
                  Logout
                </v-list-item-title>
              </v-list-item>
              <v-list-item >
                <v-list-item-title @click="changePassword()">
                  <v-btn icon title="Change Password">
                    <v-icon>mdi-lock</v-icon>
                  </v-btn>
                    Change Password
                </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
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
      drawer: true,
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
      title: 'Premium Admin'
    }
  },
  computed: {
    ...mapGetters(['isAuthenticated','loggedInUser'])
  },
  mounted() {
     // console.log(this.loggedInUser)
  },
  methods:{
      async logout(){
          await this.$auth.logout()
            this.$router.push('/auth/login')
      }
  }
}
</script>