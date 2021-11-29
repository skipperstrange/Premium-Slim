<template>
    <v-container fluid>
    <v-row>
      <v-col cols="12" md="12" >
        <v-card>
            <v-card-title style="padding:8px 16px 1px; margin-bottom:.1px;">
            Follow up on request for {{request.customer.name}}.
            </v-card-title>
            <v-card-text>
                <v-form ref="form" v-model="valid" lazy-validation>
            <v-textarea v-model="comment" :rules="commentRules" aria-required="true" required filled name="input-7-4" label="Comment"
          value=""
        ></v-textarea>
        <v-col cols="12" md="12" >
            <div  class="float-right">
            </div>
        <v-tooltip bottom>
            <template #activator="{ on, attrs }">
            <v-btn color="success" v-bind="attrs" v-on="on" @click="saveComment()">
                <v-icon color="white"> mdi-check-circle </v-icon> &nbsp;
                Save
            </v-btn>
            </template>
            <span>Save</span>
        </v-tooltip>
      </v-col>
      </v-form>
            </v-card-text>
      </v-card>
      </v-col>
      </v-row>
    </v-container>
</template>

<script>

export default {
    name: "RequestComment",
    props: {
        request: {}
    },
    data(){
        return {
            comment: '',
            valid: true,
            commentRules: [
                v => !!v || 'A comment is required',
                v => (v && v.length >= 5) || 'Name must be more than 5 characters',
            ],
        }
    },

    methods: {
        saveComment(){
            if (this.$refs.form.validate()) {
                this.$api.post("/comment").then((response) => {
                    console.log(response)
                }).catch(e => console.log(e))
        }
        
        },
    }
    
}
</script>