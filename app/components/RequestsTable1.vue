<template>
    <v-container fluid>
         <!--v-data-iterator
      :items="RequestData"
      :items-per-page.sync="itemsPerPage"
      :page.sync="page"
      :search="search"
      :sort-by="sortBy.toLowerCase()"
      :sort-desc="sortDesc"
      hide-default-footer
    >

    <template v-slot:header>
        <v-toolbar
          dark
          color="#blue lighten-3"
          class="mb-1"
        >
          <v-text-field
            v-model="search"
            clearable
            flat
            solo-inverted
            hide-details
            prepend-inner-icon="mdi-magnify"
            label="Search"
          ></v-text-field>
          <template v-if="$vuetify.breakpoint.mdAndUp">
            <v-spacer></v-spacer>
            <v-select
              v-model="sortBy"
              flat
              solo-inverted
              hide-details
              :items="keys"
              prepend-inner-icon="mdi-magnify"
              label="Sort by"
            ></v-select>
            <v-spacer></v-spacer>
            <v-btn-toggle
              v-model="sortDesc"
              mandatory
            >
              <v-btn
                large
                depressed
                color=""
                :value="false"
              >
                <v-icon>mdi-arrow-up</v-icon>
              </v-btn>
              <v-btn
                large
                depressed
                color="blue"
                :value="true"
              >
                <v-icon>mdi-arrow-down</v-icon>
              </v-btn>
            </v-btn-toggle>
          </template>
        </v-toolbar>
      </template>

      

    </!v-data-iterator --->
    <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    <v-data-table
      :headers="headers"
      :search="search" 
      :items="RequestData"
    >
    <template v-slot:item="{ item }">
          <tr class="cus-info">
              <td><b v-html="item.customer.name"></b> 
                  <p class="text-caption text-info"><a class="btn btn-info" :href='"mailto:"+item.customer.email+""' v-html="item.customer.email"></a></p>
              </td>
              <td><a :href='"tel:"+item.customer.mobile+""' v-html="item.customer.mobile"></a></td>
              <td><p v-html="item.policy"></p></td>
              <td><p v-html="item.property_policy"></p></td>
              <td></td>
              <td>
                  <v-btn icon title="Detailed view on item.">
                      <v-icon class="m-0" @click="viewItem(props.item)" color="primary" dark>mdi-note-search-outline</v-icon>
                  </v-btn>
                  <v-btn icon title="View User">
                      <v-icon class="m-0" @click="editItem(props.item)"  color="success">mdi-account</v-icon>
                  </v-btn>
              </td>
          </tr>
      </template>
    </v-data-table>
    </v-container>
</template>

<script>
export default{
    name: "RequestsTable",
    props: {
        RequestData: {}
    },
    data(){
        return {
        itemsPerPageArray: [4, 8, 12],
        search: '',
        filter: {},
        sortDesc: false,
        page: 1,
        organizedRequests: [],
        itemsPerPage: 4,
        sortBy: 'id',
        headers: [
        {
        text: 'Name',
        align: 'start',
        value: 'fullname',
        },
        { text: 'Contact', value: 'mobile' },
        {
        text: 'Policy',
        align: '',
        filterable: false,
        value: 'cover',
        },
        {
        text: 'Home Policy',
        align: '',
        filterable: false,
        value: 'home_cover',
        },
        // Actions column
        {
        text: '',
        align: 'center',
        filterable: false,
        value: '',
        },
       /* {
        text: 'Duration',
        align: '',
        filterable: false,
        value: 'duration',
        }, */
        ]
      }
    },
    computed: {
      
    },
    created(){
      this.orgData();  
    },
    methods:{
      orgData(){
          let i = 0
          while(i < this.RequestData.length){
               // console.log(this.RequestData[i])
              this.organizedRequests.push({
                  "fullname":`${this.RequestData[i].customer.name } <br />${this.RequestData[i].customer.email}`,
                  "mobile": this.RequestData[i].customer.mobile,
                  "cover": this.RequestData[i].cover,
                  "home_cover": this.RequestData[i].property_policy,
                  })
                i++
          }
          // console.log(this.organizedRequests)
          return true
      }
    }

   
}
</script>