require('./bootstrap');

import Vue from 'vue';
import VModal from 'vue-js-modal'

// import { Container, Draggable } from "vue-smooth-dnd";
Vue.component('board', require('./components/Board.vue'));
Vue.component('card-table', require('./components/CardTable.vue'));
Vue.component('deck-bag', require('./components/DeckBag.vue'));
Vue.component('deck-maker', require('./components/DeckMaker.vue'));
Vue.component('card-picker', require('./components/CardPicker.vue'));
Vue.component('draggable-cards-container', require('./components/DraggableCardsContainer.vue'));
 
Vue.use(VModal)

Vue.prototype.$applyDrag = function(arr, dragResult){
  // const { removedIndex, addedIndex, payload } = dragResult
  // if (removedIndex === null && addedIndex === null) return arr

  // const result = [...arr]
  // let itemToAdd = payload

  // if (removedIndex !== null) {
  //   itemToAdd = result.splice(removedIndex, 1)[0]
  // }

  // if (addedIndex !== null) {
  //   result.splice(addedIndex, 0, itemToAdd)
  // }

  // return result
  console.log('test')
}

const app = new Vue({
    // components: { Container, Draggable },
    el: '#app'
});
