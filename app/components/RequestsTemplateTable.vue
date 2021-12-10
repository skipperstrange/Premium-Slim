<template>
<div>
  <v-data-table :headers="headers" :items="requestData" class="elevation-0">
   <template #item="{ item }">
     <tr class="my-table-data">
      <td>
        <b>{{item.customer.name}}</b> <small class="mute small">{{item.id}}</small>
        <p class="text-caption text-info"><a class="btn btn-info" :href='"mailto:"+item.customer.email+""'>{{item.customer.email}}</a></p>
      </td>
      <td style="text-align: center;"><b>{{item.customer.mobile}}</b>
            <p>
             <a :href='"https://wa.me/"+item.customer.mobile+""'> 
             <v-icon  title="Send a whatsapp message." target="_blank" small color="success" >mdi-whatsapp</v-icon>
             </a>
             <a :href='"tel:"+item.customer.mobile+""' title="Call this customer."> 
               <v-icon small class="m-0" color="primary" >mdi-phone</v-icon>
               </a>
            </p>
             </td>
             <td>
               <b>{{item.policy}}</b>
                <p class="mute small">{{currencyMaps[item.currency]}} {{item.vehicle_value}}, {{ durationMaps[item.duration]}}</p>
              </td>
             <td><b>{{item.property_policy}}</b>
               <p class="mute small"> 
                 <span v-if="item.property_value">{{currencyMaps[item.currency]}} {{item.property_value}}</span>  
                 <span v-if="item.property_content_value">,{{currencyMaps[item.currency]}} {{item.item.property_content_value}}</span>  
               </p>
              </td>
             <!--td :title="item.status" ><v-icon small :color="statusColors[item.status].color">{{statusColors[item.status].icon}}  </v-icon>
             </td-->
             <td>
                <v-icon small title="Details." color="success" @click="previewRequest(item)" dark>mdi-format-list-bulleted</v-icon>
                <v-spacer></v-spacer>
                <v-icon small title="Comment on item. N.B. This will be marked as pending for a follow up" color="warning" @click="openComments(item)" >mdi-message-outline</v-icon>
            </td>
      </tr>
   </template>
   
    <template #no-data>
      <h2>No Data</h2>
    </template>
  </v-data-table>
    <v-dialog v-model="commentDialog" width="600">
      <v-card>

      <v-card-title>
      </v-card-title>
        <v-form v-model="valid" ref="form" >
       <v-toolbar :rules="commentRules" flat>
           <v-text-field placeholder="Comments? Type here." v-model="comment"></v-text-field>
        <v-btn icon>
          <v-icon @click.prevent="saveComment">mdi-send</v-icon>
        </v-btn>
        <v-menu bottom left>
            <template v-slot:activator="{ on, attrs }">
                <v-icon v-bind="attrs" v-on="on" title="Change status" :color="statusColors[editedItem.status].color">
                  {{statusColors[editedItem.status].icon}}</v-icon>
            </template>

            <v-list>
              <v-list-item v-for="(status, key) in statusOptions" :key="key" >
                <v-list-item-title @click="saveStatus(status)">
                    <v-icon :color="statusColors[status].color">{{statusColors[status].icon}}</v-icon>
                    {{status}}
                </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
      </v-toolbar>
      </v-form>
      <v-divider></v-divider>

        <v-list-item v-for="item in comments" :key="item.id" three-line>
          <v-list-item-content>
            <v-list-item-subtitle>
              {{item.comment}}
            </v-list-item-subtitle>
             <v-list-item-subtitle>{{item.created_at}}</v-list-item-subtitle>
          </v-list-item-content>
          </v-list-item>
        </v-card>
  </v-dialog>
  </div>
</template>
<script>
  export default {
    props: ['requestData'],
    data: () => ({
      valid: true,
      dialog: false,
      dialogDelete: false,
      comment: '',
      comments: null,
      commentDialog: false,
      requestComments: [],
      statusOptions: [],
      statusColors: {
                "complete":{"color": "green", "icon": "mdi-checkbox-marked-circle"},
                "pending":{"color": "orange", "icon": "mdi-checkbox-marked-circle-outline"},
                "failed":{"color": "red", "icon": "mdi-cancel"},
                "unfollowed":{"color": "", "icon": "mdi-cancel"}
      },
      statuses: ["complete", "pending", "failed"],
      status: ["complete", "pending", "failed", "unfollowed"],

      commentRules: [
        value => !!value || 'Please add a comment.'
      ],
      headers: [
        { text: 'Name', align: 'start', value: 'fullname', filterable: true, sortable: true,
        },
        { text: 'Contact', value: 'mobile', align: 'center',  sortable: true,},
        { text: 'Policy', align: 'center', filterable: true, value: 'cover', },
        { text: 'Home Policy', align: 'center', filterable: false, value: 'home_cover', },
        // { text: 'Status', align: 'center', filterable: false, value: 'status', },
        { text: 'Actions',  align: 'center', value: 'actions', sortable: false },
      ],
      durationMaps: ["", "1 Month", "3 Months", "6 Months", "12 Months"],
      currencyMaps: ["", "GH¢", "US$"],
      editedIndex: -1,
      editedItem: {
        fullname: '',
        contact: '',
        cover: 0,
        home_cover: 0,
        status: '',
      },
      defaultItem: {
        fullname: '',
        contact: '',
        cover: 0,
        home_cover: 0,
        status: '',
      },
    }),

    computed: {
      
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
     
    
    },

    mounted(){
    },

    

    methods: {

      openWhatsappDialogConfirm(){},

      previewRequest (item) {
        this.editedIndex = this.requestData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        console.log(this.editedItem)
        this.dialog = true
      }, 

      openComments (item) {
        this.editedIndex = this.requestData.indexOf(item)
        if(this.editedItem.id !== undefined || this.editedItem.id !== null){
        this.getComments(this.editedItem.id)
        this.statusOptions = []
        this.statuses.forEach((i, e)=>{
          if(this.editedItem.status !== i){
            this.statusOptions.push(i)
          }
        })
        this.editedItem = Object.assign({}, item)
        this.commentDialog = true
        }
      },

      saveComment(){
            if (this.$refs.form.validate()) {
                this.$api.post("/comment", {comment: this.comment, request_id: this.editedItem.id})
                .then((response) => {
                  this.getComments(this.editedItem.id)
                    this.$refs.form.reset()
                    if(this.editedItem.status !== 'complete'){
                      this.saveStatus('pending')
                    }
                }).catch(e => console.log(e))
          }
      },
      
      reinitialize(){
        this.status.forEach((e, i)=>{
          this.$api.get('/requests/status/'+e).then(response=>{
            this.items.push({tab: e, content: response.data, count:response.data.length});
          })
        })
      },

      deleteItemConfirm () {
        this.desserts.splice(this.editedIndex, 1)
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.commentDialog = false
        this.comments = null
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.desserts[this.editedIndex], this.editedItem)
        } else {
          this.desserts.push(this.editedItem)
        }
        this.close()
      },

       saveStatus(status){ // Options are complete, failed, pending and unfollowed
            console.log(status)
            if(status === this.editedItem.status){
                alert('This request is already '+status+'.')
            }else{
                 this.$axios
                    // eslint-disable-next-line object-shorthand
                    .post("/status", {status: status, id: this.editedItem.id})
                    .then(response => {
                      this.editedItem.status = status
                      this.$nuxt.$emit('status-change')
                });
            }
        },

      async getComments(id){
        await this.$api.get('/comments/request/'+id).then(response=>{
                  this.comments = response.data;
                })
      }
    },
  }
</script>
