<template>
<div>
    <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
     <v-data-table
     :headers="headers"
     :items="RequestData"
     :search="search"
     class="elevation-1"
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
</div>
   
</template>

<script>
export default{
    name: "RequestsTable",
    props: {
        RequestData: {}
    },
    data(){
        return {
        filter: {},
        sortDesc: false,
        page: 1,
        organizedRequests: [],
        sortBy: 'id',
        headers: [
        {
        text: 'Name',
        align: 'start',
        value: 'fullname',
        filterable: true
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
                  "fullname":`${this.RequestData[i].customer.name }</p>`,
                  "mobile": this.RequestData[i].customer.mobile,
                  "email": this.RequestData[i].customer.email,
                  "cover": this.RequestData[i].cover,
                  "home_cover": this.RequestData[i].property_policy,
                  })
                i++
          }
          console.log(this.organizedRequests)
          return true
      }
    }
}
</script>
<style>
.cus-info td{
    font-size: 80%;
}
</style>