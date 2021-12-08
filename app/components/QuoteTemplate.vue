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
            <template #default>
                <thead style="padding-bottom:.3rem;">
                    <tr>
                    <th class="text-left"><h2>Quote Summary</h2></th>
                    <th></th>
                    </tr>
                </thead>
              <tr v-for="(detail, index) in  premiums" :key="index">
                  <td class="text-left"><b>{{index}} : </b></td>
                  <td class="text-left">{{detail}}</td>
              </tr>
              </template>
          </v-simple-table>
            <p><b>Status: </b>{{request.status}}</p>
</v-container>
        </v-card-text>
        
      </v-card> 
</div>

</template>

<script>
export default {
    name: "QuoteTemplate",
    props: {
        request: {}, 
        premiums:{},
        quoteMotorDetails: {},
        quoteHomeDetails: {},
        
    },
    data() {
        return {
            durationMaps: ["1 Month", "3 Months", "6 Months", "12 Months"],
            currency: ["GH₵", "US$"],
        }
    },
    

    methods: {
       
    }
}
</script>
