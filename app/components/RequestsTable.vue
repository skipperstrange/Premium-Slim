/* eslint-disable no-unused-expressions */
<template>
<div>
    <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
      ></v-text-field>
     <v-data-table
     :headers="headers"
     :items="RequestData"
     :search="search"
     sort-by="fullname"
     class="elevation-1"
     >
     <template #item="{ item }">
         <tr>
             <td><b>{{item.customer.name}}</b> 
                <p class="text-caption text-info"><a class="btn btn-info" :href='"mailto:"+item.customer.email+""'>{{item.customer.email}}</a></p>
            </td>
             <td style="text-align: center;"><b>{{item.customer.mobile}}</b>
             <p><a :href='"https://wa.me/"+item.customer.mobile+""' title="Send a whatsapp message." target="_blank"> <v-icon class="m-0" color="success" >mdi-whatsapp</v-icon></a>
             &nbsp; 
             &nbsp; 
             <a :href='"tel:"+item.customer.mobile+""' title="Call this customer."> <v-icon class="m-0" color="success" >mdi-phone</v-icon></a></p></td>
             <td><p>{{item.policy}}</p></td>
             <td><p>{{item.property_policy}}</p></td>
             <td><p>{{item.status}}</p></td>
             <td>
                 <v-btn icon title="View User">
                    <v-icon :class="'m-0 '+item.status" :title="item.status" @click="markDone(item)" >mdi-check-circle-outline</v-icon>
                </v-btn>
                <v-btn icon title="Detailed view on item.">
                    <v-icon class="m-0" color="primary" @click="previewRequestQuote(item)" dark>mdi-note-search-outline</v-icon>
                </v-btn>
                <v-btn icon title="View User">
                    <v-icon class="m-0" title="Comment on item. N.B. This will be marked as pending for a follow up" color="warning" @click="comment(item)" >mdi-message-outline</v-icon>
                </v-btn>
            </td>
         </tr>
     </template>
   </v-data-table>

     <v-dialog v-model="dialog" width="60%" xs12 md6 lg6 >
         <div  v-if="showQuoteDialog">
           <QuoteTemplate :request="selectedRequest" :premiums="premiums" :quoteMotorDetails="quoteMotorDetails" :quoteHomeDetails="quoteHomeDetails" />
         </div>
         <div  v-if="showCommentDialog">
             <RequestComment :request="selectedRequest" />
         </div>
         <div  v-if="showDoneDialog">
             <DoneDialog :request="selectedRequest" />
         </div>
    </v-dialog>
   

</div>
</template>

<script>
import QuoteTemplate from './QuoteTemplate.vue'
import RequestComment from './RequestComment.vue'
export default{
    name: "RequestsTable",
    components:{
        QuoteTemplate,
        RequestComment
        },
    props: {
        RequestData: {}
    },
    data(){
        return {
        sortDesc: false,
        page: 1,
        search: "",
        organizedRequests: [],
        selectedRequest: {},
        sortBy: 'id',
        dialog: false,
        showQuoteDialog: false,
        showCommentDialog: false,
        showDoneDialog: false,
        status: [],
        durationMaps: ["1 Month", "3 Months", "6 Months", "12 Months"],
        quoteMotorDetails: {},
        quoteHomeDetails: {},
        premiums: {},
        headers: [
        {
        text: 'Name',
        align: 'start',
        value: 'fullname',
        filterable: true,
        filter:  value => {
              if (!this.fullname) return true
              return value < parseInt(this.fullname)
            }
        },
        { text: 'Contact', value: 'mobile', align: 'center', },
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
        
        {
        text: 'Status',
        align: 'center',
        filterable: false,
        value: 'status',
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
    mounted(){
        // eslint-disable-next-line dot-notation
        this.status['pending'] = "warning"
         // eslint-disable-next-line dot-notation
        this.status['failed']= "danger"
         // eslint-disable-next-line dot-notation
        this.status['complete']="success"
         // eslint-disable-next-line dot-notation
        this.status['unfollowed']=""
    
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
           this.setupQuoteData(request)
            this.openDialog('quote', request)
       },
       viewCustomer(customer){
           this.openDialog('customer', customer)
       },
       comment(request){
           this.openDialog('comment', request)
       },

       markDone(item){
           this.openDialog('status', item)
       },

       // choose which dialogto show - quote, customer, comment
       enableDialog(dialog, request){

        this.selectedRequest = request
        // eslint-disable-next-line no-empty
        switch (dialog){
            case 'quote':
                this.showQuoteDialog = true
            break;
            case 'request':
                this.showRequestDialog = true
            break;
            case 'status':
                this.showDoneDialog = true
            break;
            case 'comment':
                this.showCommentDialog = true
            break;
        }
       },

        disableDialog(){
            this.showQuoteDialog = false
            this.showCommentDialog = false
            this.showDoneDialog = false
        },

        openDialog(dialog, request){
            this.closeDialog()
            this.enableDialog(dialog, request)
            this.dialog = true
        },

        closeDialog(){
            this.dialog = false;
            this.disableDialog()
        },

        setupQuoteData(request){
            this.calculateQuote().then(e=>{
                this.quoteMotorDetails = {}

            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails['Policy'] = request.policy 
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails['Duration'] = this.durationMaps[(this.selectedRequest.duration - 1)] 
            this.quoteMotorDetails["Year of Manufacture"] = request.manufacture_year 
            this.quoteMotorDetails["Vehicle Value"] = request.vehicle_value 
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails["Capacity"] =request.engine_cap_cc 
            this.quoteMotorDetails["Claim Free"] = request.claim_free 
            this.quoteMotorDetails["Addition Third Party"] = request.additional_third_party 
            this.quoteMotorDetails["Request Date"] = request.request_date 
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails["Seats"] = request.seats 
            
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails["Usage"] = request.usage 
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails["Excess"] = request.excess 

this.quoteHomeDetails = {}

            // eslint-disable-next-line dot-notation
            this.quoteHomeDetails["Home Policy"] = request.property_policy 

            this.quoteHomeDetails["Property Value"] = request.property_value 
            
            this.quoteHomeDetails["Content Value"] = request.property_content_value 
            });

            
        },

        async calculateQuote(){
            const bodyFormData = new FormData()
            // eslint-disable-next-line no-undef
            // eslint-disable-next-line prefer-const
            for ( let key in this.selectedRequest.original ) {
                // eslint-disable-next-line no-undef
                bodyFormData.append(key, this.selectedRequest.original[key]);
            }
            
            await this.$premiumapi({ method: 'post', url: 'getpremium.php', data: bodyFormData, headers: {'Content-Type': 'multipart/form-data' } }).then(response => {
           
            this.premiums = response.data.message;
            this.quoteSummary['Homeprehensive Premium'] = this.premiums.homeprehensivepremium
            this.quoteSummary['Home Premium'] = this.premiums.homeinsurancepremium
            this.quoteSummary['Motor Premium'] = this.premiums.motorpremium
            return true
            }).
            catch(e=>{
                console.log(e)
            });
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

.complete{
    color:green;
}

</style>