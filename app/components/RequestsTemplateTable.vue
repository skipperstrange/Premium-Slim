<template>
<div>
  <v-data-table :headers="headers" :items="requestData" class="elevation-0">
   <template #item="{ item }">
     <tr class="my-table-data">
      <td>
        <b>{{item.customer.name}}</b> 
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
             <td :title="item.status" ><v-icon small :color="statusColors[item.status].color">{{statusColors[item.status].icon}}  </v-icon>
             </td>
             <td>
                <v-icon small title="Details." color="success" @click="previewRequest(item)" dark>mdi-format-list-bulleted</v-icon>
               
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
        <v-card-title></v-card-title>
        <v-form ref="form" >
       <v-toolbar :rules="commentRules" flat>
           <v-text-field placeholder="Comments? Type here." v-model="comment"></v-text-field>
        <v-btn icon>
          <v-icon @click.prevent="saveComment">mdi-send</v-icon>
        </v-btn>
        <v-btn icon>
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
      </v-toolbar>
      </v-form>
      <v-divider></v-divider>


        </v-card>
  </v-dialog>
  </div>
</template>
<script>
  export default {
    props: ['requestData'],
    data: () => ({
      dialog: false,
      dialogDelete: false,
      comment: '',
      commentDialog: false,
      requestComments: [],
      statusColors: {
                "complete":{"color": "green", "icon": "mdi-check"},
                "pending":{"color": "orange", "icon": "mdi-check"},
                "failed":{"color": "red", "icon": "mdi-cancel"},
                "unfollowed":{"color": "", "icon": "mdi-cancel"}
      },
      commentRules: [
        value => !!value || 'Please add a comment.'
      ],
      headers: [
        { text: 'Name', align: 'start', value: 'fullname', filterable: true, sortable: true,
        },
        { text: 'Contact', value: 'mobile', align: 'center',  sortable: true,},
        { text: 'Policy', align: 'center', filterable: true, value: 'cover', },
        { text: 'Home Policy', align: 'center', filterable: false, value: 'home_cover', },
        { text: 'Status', align: 'center', filterable: false, value: 'status', },
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
        this.editedItem = Object.assign({}, item)
        this.commentDialog = true
      },

      saveComment(){
            if (this.$refs.form.validate()) {
                this.$api.post("/comment", {comment: this.comment, request_id: this.editedItem.id})
                .then((response) => {
                    this.$refs.form.reset()
                }).catch(e => console.log(e))
          }
      },
      
      deleteItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.desserts.splice(this.editedIndex, 1)
        this.closeDelete()
      },

      close () {
        this.dialog = false
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
        },

      getComments(id){
        
      }
    },
  }
</script>
