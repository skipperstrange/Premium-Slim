<template>
<v-card>
    <v-container fluid>
    <v-row>
        <v-col cols="12" md="12" >
                <v-card-title style="padding:8px 16px 1px; margin-bottom:.1px;">
                Please define a status for the current request {{request.customer.name}}.
                </v-card-title>
                <v-card-text>
                    Current Status: {{request.status}}
                </v-card-text>
                
                    <div  class="float-right">
                        <v-tooltip top class="mt-1">
                            <template #activator="{ on, attrs }">
                            <v-btn color="success" v-bind="attrs" v-on="on" @click="saveStatus('complete')">
                                <v-icon color="white"> mdi-check-circle </v-icon> &nbsp;
                                Mark as complete.
                            </v-btn>
                            </template>
                            <span>Client was contacted successfully</span>
                        </v-tooltip>
                        <v-tooltip top  class="mt-1">
                            <template #activator="{ on, attrs }">
                            <v-btn color="red" v-bind="attrs" v-on="on" @click="saveStatus('failed')">
                                <v-icon color="white"> mdi-cancel </v-icon> &nbsp;
                                Mark as failed.
                            </v-btn>
                            </template>
                            <span>Attempt failed</span>
                        </v-tooltip>
                    </div>
        </v-col>
    </v-row>
    </v-container>

            </v-card>
</template>

<script>
export default {
    name: "DoneDialog",
    props: {
        request: {}
    },

    methods:{
        saveStatus(status){ // Options are complete, failed, pending and unfollowed
            console.log(status)
            if(status === this.request.status){
                alert('This request is already '+status+'.')
            }else{
                 this.$axios
                    // eslint-disable-next-line object-shorthand
                    .post("/status", {status: status, id: this.request.id})
                    .then(response => {
                    console.log(response)
                });
            }
        }
    }
}
</script>