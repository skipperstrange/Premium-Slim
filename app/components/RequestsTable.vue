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
     <template #item="{ item }">
         <tr>
             <td><b>{{item.customer.name}}</b> 
                <p class="text-caption text-info"><a class="btn btn-info" :href='"mailto:"+item.customer.email+""' v-html="item.customer.email"></a></p>
            </td>
             <td><a :href='"tel:"+item.customer.mobile+""'>{{item.customer.mobile}}</a></td>
             <td><p>{{item.policy}}</p></td>
             <td><p>{{item.property_policy}}</p></td>
             <td></td>
             <td>
                <v-btn icon title="Detailed view on item.">
                    <v-icon class="m-0" @click="previewRequestQuote(item)" color="primary" dark>mdi-note-search-outline</v-icon>
                </v-btn>
                <v-btn icon title="View User">
                    <v-icon class="m-0" @click="viewCustomer(item.customer)"  color="success">mdi-account</v-icon>
                </v-btn>
                <v-btn icon title="View User">
                    <v-icon class="m-0" @click="comment(item)"  color="warning">mdi-chat-outline</v-icon>
                </v-btn>
            </td>
         </tr>
     </template>
   </v-data-table>

    <v-dialog v-model="showQuoteDialog" top width="80%">
      <QuoteTemplate :request="selectedRequest" />
    </v-dialog>
   

</div>
</template>

<script>

import QuoteTemplate from './QuoteTemplate.vue'
export default{
    name: "RequestsTable",
    components:{
        QuoteTemplate,
        },
    props: {
        RequestData: {}
    },
    data(){
        return {
        filter: {},
        sortDesc: false,
        page: 1,
        search: "",
        organizedRequests: [],
        selectedRequest: {},
        sortBy: 'id',
        dialog: false,
        showQuoteDialog: false,
        showCommentDialog: false,
        showCustomerDialog: false,
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
          return true;
      },

       previewRequestQuote(request){
           this.selectedRequest = request
           this.openDialog('quote')
       },
       viewCustomer(customer){
           this.openDialog('customer')
           console.log(customer);
       },
       comment(request){
           this.openDialog('comment')
           console.log(request)
       },

       // choose which dialogto show - quote, customer, comment
       enableDialogue(dialog){
           // eslint-disable-next-line no-empty
           switch (dialog){
               case 'quote':
                   this.showQuoteDialog = true
               break;
               case 'request':
                    this.showRequestDialog = true
               break;
               case 'customer':
                   this.showCustomerDialog = true
               break;
           }
       },
        disableDialoge(){
            this.showQuoteDialog = false
            this.showCommentDialog = false
            this.showCustomerDialog = false
        },

        openDialog(dialog){
            this.enableDialogue(dialog)
            this.dialog = true
        },

        closeDialog(dialog){
            this.dialog = false;
            this.disableDialoge()
        }
    }
}
</script>
<style>
.v-data-table > .v-data-table__wrapper > table > tbody > tr > td,
.v-data-table > .v-data-table__wrapper > table > tfoot > tr > td,
.v-data-table > .v-data-table__wrapper > table > thead > tr > td {
    font-size: 12px;
}

.v-data-table > .v-data-table__wrapper > table > tbody > tr > td a,
.v-data-table > .v-data-table__wrapper > table > tfoot > tr > td a,
.v-data-table > .v-data-table__wrapper > table > thead > tr > td a{
     text-decoration: none;
}
</style>