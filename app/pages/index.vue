<template>

       <v-card elevation="0">
    <v-tabs
      v-model="tab"
    >
      <v-tab
        v-for="item in items"
        :key="item.tab"
      >
        {{ item.tab }}
      </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item
        v-for="item in items"
        :key="item.tab"
      >
      
        <v-card flat>
          <v-card-text>
           <RequestsTable v-if="item.tab == 'Requests'" :RequestData="item.content" />
          </v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
import { mapGetters } from 'vuex'

import RequestsTable from "~/components/RequestsTable.vue";
export default {
    components: { RequestsTable },

    data() {
        return {
            tab: null,
            items: [],
            customers: [],
            requests: []
        };
    },
    computed: {
    ...mapGetters(['isAuthenticated','loggedInUser'])
  },

    mounted(){
          
          console.log(this.loggedInUser)
          if(!this.isAuthenticated){
            alert("not authenticated")
            this.$router.push('auth/login')
            }else{
              this.initialize();
            }
        },

        methods: {
          initialize(){
              this.$api.get('/requests').then(response=>{
                this.users = response.data
                this.requests.tab = "Requests";
                this.requests.content = response.data;
                this.items.push(this.requests);
            })
          }
        }
}
</script>