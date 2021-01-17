<template>

  <v-row justify="center">
    <v-dialog v-model="payment"
      persistent   max-width="320"
    >      
      <v-card>
        <v-card-title class="headline">
          Payment already done!
        </v-card-title>
         <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn  color="green darken-1"
            text @click="close" >
            OK
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="paydialog"   width="500">
      <v-card>
      <v-card-text>
        <v-form v-model="valid">
            <v-container>
                 <v-row>
                    <v-col cols="12">
                        <v-text-field v-model="invoice.schoolname"
                          label="Schoolname" disabled></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-text-field v-model="invoice.description"
                          label="Description" disabled></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-text-field v-model="invoice.amount"
                          label="Amount" disabled></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-text-field v-model="inpdata.fullname"
                          :rules="fullnameRules" label="Fullname"
                          required
                          ></v-text-field>
                    </v-col>
                </v-row>
                 
            </v-container>
        </v-form>
      </v-card-text>
      <v-card-actions>
      <v-btn :disabled="!valid" @click="pay">Pay</v-btn>
      <v-spacer></v-spacer>
      <v-btn @click="close">Cancel</v-btn>
      </v-card-actions>
      </v-card>
  </v-dialog>
    <v-snackbar  v-model="snackbar">
      Pay Done!
      <template v-slot:action="{ attrs }">
        <v-btn  color="red"  
          v-bind="attrs"
          @click="close"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </v-row>

</template>
<script>
  export default {
  props: {
      mainpath: String,
      invlink: String,
     
     },
    data () {
      return {
        snackbar:false,
        payment:false,
        paydialog:false,
        inpdata:{fullname:'', status:'ok',invoice_id:-1},
        valid:false,
        invoice:{},
        fullnameRules: [
        v => !!v || 'Name is required',
      ],
      }
    },
     mounted () {
      this.init()
  },
    methods: {
  
     pay()
     {
        this.inpdata.invoice_id = this.invoice.id
         axios.post('/pay',this.inpdata)
        .then(response => {
           this.snackbar = true
           setTimeout(this.close, 4000)
        })
        .catch(e => {
          alert('Server connect error!')
        })
     },
     close()
     {
        this.payment = false
        this.paydialog = false
        window.close()
     },
     init()
       {
          axios.get('/getinvoice/'+this.invlink).then((response) => {
          this.invoice = response.data;
          
          if(this.invoice.status!=null)
          {
            this.payment = true
            this.paydialog = false
          }
          else
          {
            this.paydialog = true
            this.payment = false
          }
        });
       }
    },
  }
</script>