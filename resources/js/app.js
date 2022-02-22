/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

// Gmap component
import Vue from 'vue'
import Multiselect from 'vue-multiselect'
import VueSweetalert2 from 'vue-sweetalert2'
import VueTimepicker from 'vue2-timepicker'
import Datepicker from 'vuejs-datepicker'

import 'sweetalert2/dist/sweetalert2.min.css'
import 'vue2-timepicker/dist/VueTimepicker.css'

Vue.use(VueSweetalert2)
Vue.component('multiselect', Multiselect)
Vue.component('vue-timepicker', VueTimepicker)
Vue.component('datepicker', Datepicker)

// components
Vue.component('line-in', require('./components/inventory/line-in').default);
Vue.component('location-table', require('./components/location/table').default);
Vue.component('product-table', require('./components/product/table').default);
Vue.component('product-sync-button', require('./components/product/sync-button').default);
Vue.component('report-table', require('./components/report/table').default);
Vue.component('schedule-table', require('./components/schedule/table').default);
Vue.component('shift-table', require('./components/shift/table').default);
Vue.component('shift-form', require('./components/shift/form').default);
Vue.component('sync-log', require('./components/sync/table-log').default);


// filters
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});

const app = new Vue({
    el: '#app'
});
 