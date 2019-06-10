<template>
    <div class="deck-macker d-flex">
        <div class="available-cards">   
            <draggable
                class="dragArea card-picker card-container"
                :group="{ name: 'deck-cards', pull: 'clone', put: false }"
                v-model="allCards" 
                draggable=".card" 
            >
                <transition-group>
                    <div v-for="(card, key) in allCards" :key="key" class="card p-1">
                        <h5> {{key}} <span class="card-name">{{card.name}}</span></h5>
                        <h6> <span class="card-id">{{card.id}}</span> <span class="card-subtitle">{{card.subtitle}}</span></h6>
                    </div>
                </transition-group>
            </draggable>
        </div>

        <div class="deck-container">
            <h3>Deck</h3>

            <div class="input-group mb-3">
                <input type="text" class="form-control auto-input" v-model="deck.name" v-on:focusout="saveDeckName">

                <button class="ml-3" @click="addCategory"> add category </button>
                <button class="ml-3" @click="saveDeck"> SAVE </button>
            </div>  

            <div class="deck">
                <div class="category" v-for="(category, catKey) in allCategories" :key="catKey">

                    <div class="input-group d-flex justify-content-center">
                        <input type="text" class="form-control auto-input" v-model="category.name" v-on:focusout="updateCategory(category.id, $event)" :placeholder="'Catégorie ' +  category.id">
                    </div>  

                    <button 
                        type="button" 
                        class="close" 
                        aria-label="Close" 
                        v-on:click="deleteCategory(category)" >
                      <span aria-hidden="true">&times;</span>
                    </button>   

                    <div class="cards pt-1">
                        <draggable-cards-container 
                        :base-url="urlAjax" 
                        :items='category.cards'
                        :category-id='category.id'
                        v-on:updated-cards="updateCardsCategory($event, category.id)">
                        </draggable-cards-container>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    // import axios from 'axios';

    export default {  
        components: {},
        props:{
            deck: {
            }, 
            urlAjax:{},
            baseUrl:{},
            author:{},
            cards:{},
            baseUrl:{}
        },
        data: function () {
            return {
                allCategories: this.deck.categories,
                allCards: this.cards,
            }
        },
        computed:{
        },
        mounted() {
        },
        methods:{
            saveDeck: function(){
                var vueApp = this;
                this.$emit('saveDeckCards')
                // this.flash('Saved! 😊', 'success', {
                //   timeout: 1000
                // });
                // console.log(this.allCategories)

                axios.post(this.urlAjax + '/cards/update', {
                    _token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    _data: this.allCategories,
                })
                .then(response => {
                    console.log(response.data)

                    // if(response.data == true){
                    // }
                    // else{
                    // }
                })
                .catch(e => {
                  console.log(e)
                })
            },
            updateCardsCategory: function(event, categoryId){
                var tempCategory = this.allCategories.find(
                    function(element){
                      return element.id == categoryId;
                    }
                );

                tempCategory.cards = event;
            },
            updateCategory:function(categoryId, event){
                this.autoInputReset(event.target);

                var tempCategory = this.allCategories.find(
                    function(element) {
                      return element.id == categoryId;
                    }
                );

                axios.post(this.urlAjax + '/category/update', {
                  _token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                  _data: tempCategory,
                })
                .then(response => {
                    console.log(response.data)
                    if(response.data == true){
                        this.autoInputSuccess(event.target);
                    }
                    else{
                        this.autoInputFailed(event.target);
                    }
                })
                .catch(e => {
                  console.log(e)
                })
            },
            addCategory: function(){
                axios.post(this.urlAjax + '/category/add', {
                  _token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                  _data: this.deck,
                })
                .then(response => {
                    console.log('success')

                    if(response.data !== null)
                    {   
                        this.allCategories.unshift(response.data);
                    }

                })
                .catch(e => {
                  console.log(e)
                })
            },
            deleteCategory: function(category){

                var vueApp = this;
                vueApp.toDelete = category;    

                axios.post(this.baseUrl + '/categories/' + category.id + '/delete', {
                  _token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                  _data: this.deck,
                })
                .then(response => {
                    console.log('success')
                    if(response.data == true)
                    {
                        var index = this.allCategories.indexOf(this.toDelete);
                        this.allCategories.splice(index, 1);
                    }
                })
                .catch(e => {
                  console.log(e)
                })
            },
            saveDeckName:function(event){
                var vueApp = this; 

                this.autoInputReset(event.target);
                console.log(document.querySelector('meta[name=csrf-token]').getAttribute('content'))

                axios.post(this.baseUrl + '/decks/' + this.deck.id + '/update', {
                  _token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                  _data: this.deck,
                })
                .then(response => {
                    console.log(response.data)
                    if(response.data == true)
                    {
                        this.autoInputSuccess(event.target);
                    }
                    else{
                        this.autoInputFailed(event.target);
                    }
                })
                .catch(e => {
                  console.log(e)
                })
            }

        }
    }
    
</script>


<style scoped lang="scss">
    .deck-macker{
        margin-top: 1rem;
        display: flex;
        flex-direction: row;
        width: 100%;

        .available-cards{
            width: 25vw;
        }
        .deck-container{
            width: 75vw;
        }

        .deck{
            display: flex;
            flex-direction: row;
            margin-top: 1rem;
            padding: 2rem 0;
            position: relative;
            top: -2rem;
            min-height: 300px;
            // border: red 1px solid;

            .category{   
                border: solid 2px grey;
                margin-right: 2rem;
                position: relative;
                overflow:visible;  

                .cards{
                    // border: solid 2px green;
                    min-height: 100%;
                } 

                .close{
                    position: absolute;
                    right: -20px;
                    top: -20px;
                    border-radius: 100%;
                    width: 40px;
                    height: 40px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    padding: 0; margin: 0;
                    background-color: white;
                    border-color: red;
                }

            }
        }
    }
</style>