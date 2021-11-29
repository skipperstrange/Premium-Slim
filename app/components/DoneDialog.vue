<template>
    <v-container fluid>
    <v-row>
        <v-col cols="12" md="12" >
            <v-card>
                <v-card-title style="padding:8px 16px 1px; margin-bottom:.1px;">
                Please define a status for the current request {{request.customer.name}}.
                </v-card-title>
                <v-card-text>
                    Current Status: {{request.status}}
                </v-card-text>
                
                    <div  class="float-right">
                        <v-tooltip bottom>
                            <template #activator="{ on, attrs }">
                            <v-btn color="success" v-bind="attrs" v-on="on" @click="saveComment()">
                                <v-icon color="white"> mdi-check-circle </v-icon> &nbsp;
                                Mark as complete.
                            </v-btn>
                            </template>
                            <span>Save</span>
                        </v-tooltip>
                    </div>
            </v-card>
        </v-col>
    </v-row>
    </v-container>
</template>

<script>
export default {
    name: "DoneDialog",
    props: {
        request: {}
    }
}
</script>