import App from "./components/App";
require('./bootstrap');
import Vue from 'vue'

import VueRouter from 'vue-router'
import router from './routes';
import store from './index';
import VeeValidate from 'vee-validate';
import VueStripeCheckout from 'vue-stripe-checkout';
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify);
Vue.use(VueStripeCheckout, 'pk_test_RlXH1I8awnngOj6V9mzdwG3P00enKwr5bm');
Vue.use(VeeValidate);
Vue.use(VueRouter);


// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

 // const App =Vue.component('example-component', require('./components/App.vue').default);


const app = new Vue({
    router,
    store,
    render: h => h(App),
    created(){
        let user = localStorage.getItem(('user'));
        if(user) this.$store.commit('auth',JSON.parse(user))
    }
}).$mount('#app');
