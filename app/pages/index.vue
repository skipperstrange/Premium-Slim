<template>
    <v-card elevation="0">
    <v-tabs v-model="tab">
      <v-tab v-for="item in items" :key="item.tab" >
      <v-badge color="error" :content="item.count">
            {{ item.tab }} 
          </v-badge>
      </v-tab>
      
    </v-tabs>
    <v-tabs-items v-model="tab">
      <v-tab-item v-for="item in items" :key="item.tab">
        <v-card flat>
          <v-card-text>
           <RequestsTable  :requestData="item.content" />
          </v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
import { mapGetters } from 'vuex'

import RequestsTable from "~/components/RequestsTemplateTable.vue";
export default {
    components: { RequestsTable },

    data() {
        return {
            tab: null,
            items: [],
            customers: [],
            requests: [],
            status: ['complete', 'failed', 'pending','unfollowed'],
        };
    },
    computed: {
    ...mapGetters(['isAuthenticated','loggedInUser'])
  },

    mounted(){
        if(!this.isAuthenticated){
            this.$router.push('auth/login')
            }else{
              this.initialize();
            }
        },

        methods: {
          initialize(){
              
              this.status.forEach((e, i)=>{
                this.$api.get('/requests/status/'+e).then(response=>{
                  this.items.push({tab: e, content: response.data, count:response.data.length});
                })
              })
          }
        }
}
</script>