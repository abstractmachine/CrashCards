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
                <button class="ml-3" @click="saveDeck" v-if="saveEnable"> Enregistrer </button> 
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
            originalDeck: {
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
                originalDeckCards: [],
                originalCategories: this.originalDeck.categories,
                saveEnable: false
            }
        },
        watch: {
        },
        computed:{
        },
        mounted() {
            for (var i = 0; i < this.originalDeck.categories.length; i++) {
                for (var y = 0; y < this.originalDeck.categories[i].cards.length; y++) {
                    this.originalDeck.categories[i].cards[y].category_id = this.originalDeck.categories[i].id;
                }
            }
            // console.log(this.originalDeckCards);
        },
        methods:{
            cardsIsModified: function(){
                console.log("cardsIsModified")
                if(this.allCategories.length == this.originalCategories.length){

                    for (var i = 0; i < this.allCategories.length; i++) {

                        if(this.allCategories[i].cards.length == this.originalCategories[i].cards.length){

                            for (var y = 0; y < this.allCategories[i].cards.length; y++) {

                                if(this.allCategories[i].cards[y].name != this.originalCategories[i].cards[y].name ||
                                    this.allCategories[i].cards[y].subtitle != this.originalCategories[i].cards[y].subtitle ||
                                    this.allCategories[i].cards[y].id != this.originalCategories[i].cards[y].id ||
                                    this.allCategories[i].cards[y].created_at != this.originalCategories[i].cards[y].created_at ||
                                    this.allCategories[i].cards[y].updated_at != this.originalCategories[i].cards[y].updated_at
                                    ){
                                    console.log('card is differente ')
                                    return true;
                                }

                            }

                            return false;
                        }
                        else{
                            console.log('category cards length is differente.')
                            return true;
                        }

                        console.log('end chceckin')

                    }

                    return false;
                }
                else {
                    console.log('category length size is differente ')
                    return true;
                }

            },
            saveDeck: function(){
                var vueApp = this;

                // console.log(this.allCategories)

                axios.post(this.urlAjax + '/cards/update', {
                    _token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    _data: this.allCategories,
                })
                .then(response => {
                    console.log(response.data)

                    if(response.data == true){
                        this.flash('Saved! 😊', 'success', {
                          timeout: 1000,
                        });
                        setTimeout(function(){
                            //clone 
                            vueApp.originalCategories = JSON.parse(JSON.stringify(vueApp.allCategories));
                            this.saveEnable = this.cardsIsModified();
                            console.log("this.saveEnable = " + this.saveEnable)

                        }.bind(vueApp), 1000)
                    }
                    else{
                        this.flash('Non enregistré, quelque chose ne vas pas.', 'error', {
                          timeout: 1000
                        });
                    }
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

                this.saveEnable = this.cardsIsModified();
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