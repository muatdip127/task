require('./bootstrap');
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'

var admincomponent = require('./components/admincomponent.vue').default;
var payercomponent = require('./components/payercomponent').default;
Vue.use(Vuetify);

new Vue({
    data: {
    current_url: '',
  },
  components: {admincomponent,payercomponent},

  //idb: idb,
  vuetify: new Vuetify({
     icons: {
    iconfont: 'mdi', // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4'
  },
})
}).$mount('#app');
