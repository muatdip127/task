<template>
<v-main>
<div>
  <v-container>
  <v-dialog v-model="adddialog"   width="500">
      <v-card>
      <v-card-text>
        <v-form v-model="valid">
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <v-text-field v-model="inpdata.schoolname"
                          :rules="schoolnameRules" label="School name"
                          required
                          ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                        v-model="inpdata.description"           
                        label="Description"
                         ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                        v-model="inpdata.amount"
                        type="number"
                        :rules="amountRules"
                        label="Amount"
                        required
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-container>
        </v-form>
      </v-card-text>
      <v-card-actions>
      <v-btn :disabled="!valid" @click="add">Create</v-btn>
      <v-spacer></v-spacer>
      <v-btn @click="adddialog=false">Cancel</v-btn>
      </v-card-actions>
      </v-card>
  </v-dialog>
   <v-btn @click = "addinvoice">Add invoice</v-btn>
    <v-data-table
    :headers="headers"
    :items="invoices"
    class="elevation-1"
  >
   <template v-slot:body="{ items }">
        <tbody>
          <tr v-for="item in items"  :key="item.schoolname">
            <td>{{ item.schoolname }}</td>
            <td>{{item.description}}</td>
            <td>{{item.amount}}</td>
            <td>{{item.status}}</td>
            <td><v-btn @click="go(mainpath+'/'+item.invoicelink)" >{{mainpath+'/'+item.invoicelink}}</v-btn></td>
            <td>{{item.fullname}}</td>
          </tr>
        </tbody>
      </template>
  </v-data-table>
  </v-container>
</div>
</v-main>
</template>
<script>
  export default {
  props: {
      mainpath: String,  
     },
    data () {
      return {
        valid:false,
        headers:[{ text: 'Schoolnames', value: 'schoolname' },
        { text: 'Description', value: 'description' },
        { text: 'Amount', value: 'amount' },
        { text: 'Payment status', value: 'status' },
        { text: 'Invoice link', value: 'invoicelink' },
        { text: 'Payer name', value: 'fullname' }],
        inpdata:{schoolname:'',description:'', amount:'', fullname:'',id:'',invoice_id:'',invoicelink:'',status:'',created_at:'',updated_at:''},
        invoices:[],
        adddialog:false,
        schoolnameRules: [
        v => !!v || 'Name is required',
      ],
      amountRules: [
        v => v>0 || 'Amount is incorrect!',
      ],
      }
    },
     mounted () {
      this.init()
  },
  computed: {
   
  },
    methods: {
     addinvoice()
     {
       this.adddialog = true
     },
     go(href)
     {
        window.open(href)
     },
     add()
     {
         axios.post('/addinvoice',this.inpdata)
        .then(response => {
          this.invoices.push(this.inpdata)
          console.log(this.invoices)
          this.adddialog = false
        })
        .catch(e => {
          alert('Server connect error!')
        })
     },
     init()
       {
       axios.get('/invoices').then((response) => {
          this.invoices = response.data;
        });
       }
    },
  }
</script>