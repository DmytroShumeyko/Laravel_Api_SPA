
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
/* Vuex */
import store from './vuex';
/* VueRouter */
import router from './routes';
/* VueSweetAlert */
import VueSweetAlert from 'vue-sweetalert'
window.Vue.use(VueSweetAlert);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('AddModal', require('./components/AddModal'));
Vue.component('OrderModal', require('./components/OrderModal'));
Vue.component('SaleModal', require('./components/SaleModal'));


const app = new Vue({
    el: '#app',
    router,
    store,
    mounted() {

    },
    created() {
        this.$store.dispatch('loadData');
    },
});
$(document).ready(function () {

})