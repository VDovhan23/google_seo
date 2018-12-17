
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from "moment";

import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
    { path: '/dashboard', component: require('./components/DashboardComponent.vue') },
    { path: '/profile', component: require('./components/ProfileComponent.vue') },
    { path: '/show/:id', component: require('./components/ShowComponent.vue'), props: true }
  ]

  const router = new VueRouter({
    mode: 'history',
    routes
  })

  Vue.filter('dateFormat', function(date){
        return moment(date).format('MMMM Do YYYY');
  });

  import Swal from 'sweetalert2'
  window.swal = Swal;

  const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  window.toast = toast;

  window.Fire = new Vue();


Vue.component('example-component', require('./components/ExampleComponent.vue'));


const app = new Vue({
    el: '#app',
    router
});
