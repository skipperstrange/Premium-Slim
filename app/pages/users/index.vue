<template>
<v-data-table
    :headers="headers"
    :items="users"
    sort-by="username"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Users</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template #activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
              New User
            </v-btn>
          </template>
          <v-card>
              <v-form ref="form" v-model="valid" lazy-validation>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                  >
                    <v-text-field
                      v-model="editedItem.first_name"
                      label="First Name" required :rules="firstNameRules"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-text-field
                      v-model="editedItem.last_name"
                      label="Last Name" required :rules="lastNameRules"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-text-field
                      v-model="editedItem.username"
                      label="Username" required :rules="usernameRules"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-combobox label="Role" v-model="editedItem.role" outlined dense :items="roles" :rules="[v => !!v || 'Please select a role for this user']"></v-combobox>
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <span class="text-mute"> N. B. default password is (default) without the brackets</span>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancel
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Save
              </v-btn>
            </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogActivate" max-width="500px">
          <v-card>
            <v-card-title class="text-h6">Are you sure you want to {{activationText}} this user?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeUserActivate">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="activationConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template #[`item.actions`]="{ item }">
      <v-icon title="Edit this user" small class="mr-2" @click="editUser(item)">
        mdi-pencil
      </v-icon>
      <v-icon title="Reset password" small class="mr-2" @click="resetUserPassword(item)">
        mdi-sync
      </v-icon>

      <v-icon :title="activationText" small :color="statusColors[item.status].color" @click="activation(item)">
        {{statusColors[item.status].icon}}
      </v-icon>
    </template>
    <template v-slot:no-data >
      <v-btn
        color="primary"
        @click="initialize"
      >
        Refresh
      </v-btn>
    </template>
  </v-data-table>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    name: "UsersPage",
    props:{},
    
    data(){
        return {
        statusColors: {
                "active":{"color": "green", "icon": "mdi-check"},
                "disabled":{"color": "red", "icon": "mdi-cancel"}
            },
        activationOption: '',
        newStatus: "",
        activationText: '',
        dialogActivate: false,
        dialog: false,
        users: [],
        valid: true,
        roles: ['orperator', 'administrator'],
        editedIndex: -1,
        editedItem: {
        first_name: '',
        last_name: '',
        username: '',
        role: 'orperator',
        },
        defaultItem: {
        first_name: '',
        last_name: '',
        username: '',
        role: 'orperator',
        },
        firstNameRules: [
                v => !!v || 'A name is required',
                v => (v && v.length >= 2) || 'Name must be more than 2 characters',
            ],
        lastNameRules: [
                v => !!v || 'A last name is required',
                v => (v && v.length >= 2) || 'Last name must be more than 2 characters',
            ],
        usernameRules: [
                v => !!v || 'Username is required',
                v => /.+@.+\..+/.test(v) || 'Username must be an email format',
            ],
        headers: [
        {
          text: 'First Name',
          align: 'start',
          sortable: true,
          value: 'first_name',
        },
        {
          text: 'Last Name',
          align: 'start',
          sortable: true,
          value: 'last_name',
        },
        { text: 'Username', value: 'username' },
        { text: 'Role', value: 'role', sortable: false },
        { text: 'Actions', value: 'actions', sortable: false }
        ]
        }
    },

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New User' : 'Edit User'
      },
    ...mapGetters(['isAuthenticated','loggedInUser'])
  },


    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogActivate (val) {
        val || this.closeUserActivate()
      },
    },

    mounted(){ 
      if(!this.isAuthenticated){
      this.$router.push('auth/login')
      }else{
        this.initialize();
      }
    },
    methods: {

        initialize(){
            this.$api.get('/users').then(response=>{
                this.users = response.data
            })
        },

        editUser (item) {
        this.editedIndex = this.users.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      activation (item) {
        this.editedIndex = this.users.indexOf(item)
        this.editedItem = Object.assign({}, item)
        if(this.editedItem.status === 'disabled'){
              this.activationText = 'activate'
          }else if(this.editedItem.status === 'active'){
              this.activationText = 'deactivate'
          }
        this.dialogActivate = true
      },

      activationConfirm () {
        if(this.editedItem.status === 'disabled'){
              this.newStatus = 'active'
          }else if(this.editedItem.status === 'active'){
              this.newStatus = 'disabled'
          }
          
           this.editedItem.status = this.newStatus
           this.$api.post('/users/edit',{user: this.editedItem}).then(response=>{
                this.editedItem = response.data
                    Object.assign(this.users[this.editedIndex], this.editedItem)
                console.log(this.editedItem)
                setTimeout(()=>{ this.closeUserActivate()}, 1000)
            })
            .catch(e=>{
                console.log(e)
            })
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      deactivateUserConfirm(item){

      },

      closeUserActivate () {
        this.dialogActivate = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        
          let url
        if (this.editedIndex > -1) {
            url = '/users/edit'
        }else{
             url = '/users/create'
        }
        if (this.$refs.form.validate()) {
        this.$api.post(url,{user: this.editedItem}).then(response=>{
                this.editedItem = response.data
                this.editedItem.status = 'disabled'
                console.log(this.editedItem)
                if (this.editedIndex > -1) {
                    Object.assign(this.users[this.editedIndex], this.editedItem)
                }else {
                    this.users.push(this.editedItem)
                }
                setTimeout(()=>{ this.close()}, 700)
            })
            .catch(e=>{
                console.log(e)
            })
        }
        
      },
    },
}
</script>