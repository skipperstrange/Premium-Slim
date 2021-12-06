<template>
     <v-dialog v-model="dialog" persistent max-width="600px" min-width="360px">
                        <Notification :message="error" v-if="error"/>
            <div>
                <v-card class="px-4">                  
                    <v-card-text>
                        <v-form ref="loginForm" v-model="valid" lazy-validation  @submit.prevent="login">
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field v-model="loginEmail" :rules="loginEmailRules" label="E-mail" required></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field v-model="loginPassword" :append-icon="show1?'mdi-eye':'mdi-eye-off'" :rules="[rules.required, rules.min]" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Password" hint="At least 8 characters" counter @click:append="show1 = !show1"></v-text-field>
                                </v-col>
                                <v-col class="d-flex" cols="12" sm="6" xsm="12">
                                </v-col>
                                <v-spacer></v-spacer>
                                <v-col class="d-flex" cols="12" sm="3" xsm="12" align-end>
                                    <v-btn x-large block :disabled="!valid" type="submit" color="success"> Login </v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                </v-card>
            </div>
        </v-dialog>
</template>

<script>
import Notification from '~/components/Notification.vue';
export default {
    name: "Login",
    middleware: 'guest',
    components:{
        Notification
    },
    data(){
        return {
            valid: true,
            dialog: true,
            loginPassword: "default",
            loginEmail: "skipperstrange@gmail.com",
            error: null,
            loginEmailRules: [
                v => !!v || "Required",
                v => /.+@.+\..+/.test(v) || "E-mail must be valid"
            ],
            show1: false,
            rules: {
            required: value => !!value || "Required.",
            min: v => (v && v.length >= 6) || "Min 6 characters"
            }
        }
    },
    methods: {
        async login() {
                if (this.$refs.loginForm.validate()) {
                    
                try{
                    await this.$auth.loginWith('local', 
                        { data: {username: this.loginEmail, password:this.loginPassword} }
                        ).then((user)=>{
                            this.$auth.setUser(user.data.user)
                            this.$router.push('/')
                        })
                    }catch(e){
                        console.log(e)
                        this.error = "Error. Please try again"
                    } 
                }
            },
            reset() {
            this.$refs.form.reset();
            },
            resetValidation() {
            this.$refs.form.resetValidation();
            },
            
    }
}
</script>