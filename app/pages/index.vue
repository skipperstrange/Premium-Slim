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
import RequestsTable from "~/components/RequestsTable.vue";
export default {
    data() {
        return {
            tab: null,
            items: [],
            customers: [],
            requests: []
        };
    },
    created() {
        this.$axios
            .get("/customers")
            .then(response => {
            this.customers.tab = "Customers";
            this.customers.content = response.data;
            this.items.push(this.customers);
        });
        this.$axios
            .get("/requests")
            .then(response => {
            this.requests.tab = "Requests";
            this.requests.content = response.data;
            this.items.push(this.requests);
        });
    },
    components: { RequestsTable }
}
</script>