<template>
<v-data-table
    :headers="headers"
    :items="users"
    sort-by="fullname"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Users</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          max-width="500px"
        >
          <template #activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
              New User
            </v-btn>
          </template>
          <v-card>
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
                      label="First Name"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-text-field
                      v-model="editedItem.last_name"
                      label="Last Name"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-text-field
                      v-model="editedItem.username"
                      label="Username"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-combobox label="Role" v-model="roles[editedItem.role]" outlined dense :items="roles"></v-combobox>
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
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogActivate" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Are you sure you want to deactivate this user?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeUserActivate">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deactivateUserConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    // eslint-disable-next-line vue/valid-v-slot
    <template v-slot:[`item.actions`]="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editUser(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="activation(item)"
      >
        mdi-delete
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
export default {
    name: "UsersPage",
    props:{},
    
    data(){
        return {

        dialogActivate: false,
        dialog: false,
        users: [],
        roles: ['viewer', 'operator', 'administrator'],
        editedIndex: -1,
        editedItem: {
        firs_name: '',
        last_name: '',
        username: '',
        role: 'operator',
        },
        defaultItem: {
        firs_name: '',
        last_name: '',
        username: 'operator',
        role: 0,
        },
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
        this.initialize();
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
        this.dialogActivate = true
      },

      activationConfirm () {
        this.users.splice(this.editedIndex, 1)
        this.closeUserActivate()
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

        if (this.editedIndex > -1) {
            console.log(this.users[this.editedIndex])
          Object.assign(this.users[this.editedIndex], this.editedItem)
        } else {
          this.users.push(this.editedItem)
        }
        
      },
    },
}
</script>