<template>
<div>
     <v-card>
        <v-card-title style="padding:8px 16px 1px; margin-bottom:.1px;">
         {{request.customer.name}}
        </v-card-title>

        <v-card-text>
            <v-container fluid>
          <v-simple-table style="font-size:85%;">
            <template #default>
                <thead style="padding-bottom:.3rem;">
                    <tr>
                    <th class="text-left"><h2>Motor Policy Details</h2></th>
                    <th class="text-left"></th>
                    </tr>
                </thead>
              <tr v-for="(detail, index) in  quoteMotorDetails" :key="index">
                  <td class="text-left"><b>{{index}} : </b></td>
                  <td class="text-left">{{detail}}</td>
              </tr>
              </template>
          </v-simple-table>
          <v-simple-table style="font-size:85%;">
            <template v-slot:default>
                <thead style="padding-bottom:.3rem;">
                    <tr>
                    <th class="text-left"><h2>Home Policy Details</h2></th>
                    <th></th>
                    </tr>
                </thead>
              <tr v-for="(detail, index) in  quoteHomeDetails" :key="index">
                  <td class="text-left"><b>{{index}} : </b></td>
                  <td class="text-left">{{detail}}</td>
              </tr>
              </template>
          </v-simple-table>

          <v-simple-table style="font-size:85%;">
            <template v-slot:default>
                <thead style="padding-bottom:.3rem;">
                    <tr>
                    <th class="text-left"><h2>Quote Summary</h2></th>
                    <th></th>
                    </tr>
                </thead>
              <tr v-for="(detail, index) in  premiums" :key="index">
                  <td class="text-left"><b>{{index}} : </b></td>
                  <td class="text-left"> {{detail}}</td>
              </tr>
              </template>
          </v-simple-table>

            <p><b>Status: </b>{{request.status}}</p>
</v-container>
        </v-card-text>

        <v-card-actions>
          <v-btn
            color="green darken-1"
            text
            @click="calculateQuote()"
          >
            Quote Summary
          </v-btn>
        </v-card-actions>
        
      </v-card> 
</div>

</template>

<script>
export default {
    name: "QuoteTemplate",
    props: {
        request: {}
    },
    data() {
        return {
            quoteMotorDetails: {},
            quoteHomeDetails: {},
            quoteSummary: {},
            durationMaps: ["1 Month", "3 Months", "6 Months", "12 Months"],
            currency: ["GH₵", "US$"],
            premiums: {},
        }
    },
    
    created(){
        this.setupQuoteData()
    },

    methods: {
        setupQuoteData(){
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails['Policy'] = this.request.policy 
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails['Duration'] = this.durationMaps[(this.request.duration - 1)] 
            this.quoteMotorDetails["Year of Manufacture"] = this.request.manufacture_year 
            this.quoteMotorDetails["Vehicle Value"] = this.request.vehicle_value 
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails["Capacity"] = this.request.engine_cap_cc 
            this.quoteMotorDetails["Claim Free"] = this.request.claim_free 
            this.quoteMotorDetails["Addition Third Party"] = this.request.additional_third_party 
            this.quoteMotorDetails["Request Date"] = this.request.request_date 
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails["Seats"] = this.request.seats 
            
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails["Usage"] = this.request.usage 
            // eslint-disable-next-line dot-notation
            this.quoteMotorDetails["Excess"] = this.request.excess 

            // eslint-disable-next-line dot-notation
            this.quoteHomeDetails["Home Policy"] = this.request.property_policy 

            this.quoteHomeDetails["Property Value"] = this.request.property_value 
            
            this.quoteHomeDetails["Content Value"] = this.request.property_content_value 
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
           
            this.premiums = response.data.message;
            this.quoteSummary['Homeprehensive Premium'] = this.premiums.homeprehensivepremium
            this.quoteSummary['Home Premium'] = this.premiums.homeinsurancepremium
            this.quoteSummary['Motor Premium'] = this.premiums.motorpremium
            }).
            catch(e=>{
                console.log(e)
            });
        }
    }
}
</script>
