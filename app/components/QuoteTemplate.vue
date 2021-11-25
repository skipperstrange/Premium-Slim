<template>
<div>
     <v-card>
        <v-card-title class="text-h5">
         {{ request.customer.name}}
        </v-card-title>

        <v-card-text>
          
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="green darken-1"
            text
            @click="dialog = false"
          >
            Disagree
          </v-btn>

          <v-btn
            color="green darken-1"
            text
            @click="dialog = false"
          >
            Agree
          </v-btn>
        </v-card-actions>
      </v-card> 
</div>

</template>

<script>
export default {
    name: "QuoteTemplate",
    data() {
        return {
            quoteMotorDetails: {},
            quoteHomeDetails: {},
            calculatedQuote: {},
            requestStatus: "",
            durationMaps: ["1 Month", "3 Months", "6 Months", "12 Months"]
        }
    },
    props: {
        request: {}
    },
    
    created(){
        console.log(this.request)
        this.calculateQuote()
        this.setupQuoteData()
        console.log(this.request.original)
    },
    methods: {
        setupQuoteData(){
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails['Policy'] = this.request.policy 
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails['Duration'] = this.durationMaps[(this.request.duration - 1)] 
            this.quoteMotorDetails["Year of Manufacture"] = this.request.manufacture_year 
            this.quoteMotorDetails["Vehicle Value"] = this.request.value 
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails["Capacity"] = this.request.engine_cap_cc 
            this.quoteMotorDetails["Claim Free"] = this.claim_free 
            this.quoteMotorDetails["Addition Third Party"] = this.request.additional_third_party 
            this.quoteMotorDetails["Request Date"] = this.request.request_date 
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails["Seats"] = this.request.seats 
            
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails["Usage"] = this.request.usage 
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails["Excess"] = this.request.excess 

            // eslint-disable-next-line dot-notation
            this.quoteHomeDetails["Home"] = this.request.property_policy 


            this.requestStatus = this.request.status 

            console.log(this.quoteMotorDetails)
            console.log(this.quoteHomeDetails)
        },

        calculateQuote(){
            
            const bodyFormData = new FormData()
            // eslint-disable-next-line no-undef
            // eslint-disable-next-line prefer-const
            for ( let key in this.request.original ) {
                // eslint-disable-next-line no-undef
                bodyFormData.append(key, this.request.original[key]);
            }
            this.$premiumapi({ method: 'post', url: 'getpremium.php', data: bodyFormData, headers: {'Content-Type': 'multipart/form-data' } }).then(response => {
            console.log(response)
            });
        }
    }
}
</script>
