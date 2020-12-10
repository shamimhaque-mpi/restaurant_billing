
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('add-sale', require('./components/AddSale.vue').default);
Vue.component('edit-sale', require('./components/EditSale.vue').default);
Vue.component('bill', require('./components/Bill.vue').default);
Vue.component('edit-bill', require('./components/EditBill.vue').default);
Vue.component('sale-edit', require('./components/SaleEdit.vue').default);
Vue.component('all-sale', require('./components/AllSale.vue').default);

Vue.component('pagination', require('./components/partials/PaginationComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import { store } from './store';

const app = new Vue({
    el: '#app',
    store
});
