require('./bootstrap');

import Vue from 'vue';
import VModal from 'vue-js-modal'
import VueSelect from 'vue-cool-select'

// import { Container, Draggable } from "vue-smooth-dnd";
Vue.component('board', require('./components/Board.vue'));
Vue.component('card-table', require('./components/CardTable.vue'));
Vue.component('deck-bag', require('./components/DeckBag.vue'));
Vue.component('deck-maker', require('./components/DeckMaker.vue'));
Vue.component('card-picker', require('./components/CardPicker.vue'));
Vue.component('draggable-cards-container', require('./components/DraggableCardsContainer.vue'));
Vue.component('workshops-register', require('./components/WorkshopsRegister.vue'));
Vue.component('workshop-entry', require('./components/WorkshopEntry.vue'));
Vue.component('user-editor', require('./components/UserEditor.vue'));
 
Vue.use(VModal)

Vue.use(VueSelect, {
  theme: 'bootstrap' // or 'material-design'
})

Vue.mixin({
    methods: {
    	autoInputReset: function(target){
            target.classList.remove('saved-success');
            target.classList.remove('saved-failed');
            target.classList.add('saving');
    	},
    	autoInputSuccess: function(target){
            target.classList.remove('saving');
            target.classList.add('saved-success');
    	},
    	autoInputFailed: function(target){
            target.classList.remove('saving');
            target.classList.add('saved-failed');
    	}
    }
})

const app = new Vue({
    // components: { Container, Draggable },
    el: '#app',
    methods: {
    	toogleMobileNav: function(){
    		document.getElementsByClassName("mobile-nav")[0].classList.toggle('invisible');
    	}
    }
});
