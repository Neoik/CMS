require('./bootstrap');

window.Vue = require('vue');

import bFormSelect from '../../node_modules/bootstrap-vue/es/components/form-select/form-select';
Vue.component('b-form-select', bFormSelect);

import Datepicker from 'vuejs-datepicker';
Vue.component('datepicker', Datepicker);

Vue.component('shippings-component', require('./components/ShippingsComponent.vue'));
Vue.component('shipping-component', require('./components/ShippingComponent.vue'));
Vue.component('add-shipping-component', require('./components/AddShippingComponent.vue'));



const app = new Vue({
    el: '#app',
});
