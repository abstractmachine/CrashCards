require('./bootstrap');

import Vue from 'vue';

Vue.component('board', require('./components/Board.vue'));
Vue.component('card-table', require('./components/CardTable.vue'));

const app = new Vue({
    el: '#app'
});
