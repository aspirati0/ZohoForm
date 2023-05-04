import './bootstrap';

require('./bootstrap');

import Vue from 'vue';

Vue.component('zoho-form', require('./components/ZohoForm.vue').default);

const app = new Vue({
    el: '#app',
});
