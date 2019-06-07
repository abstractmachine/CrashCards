<template>
    <div class="deck-macker">
        <h3>Deck</h3>

        <div class="input-group mb-3">
            <input type="text" class="form-control auto-input" v-model="deck.name" v-on:focusout="saveDeckName">

            <button class="ml-3" @click="addCategory"> add category </button>
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

                <draggable-cards-container 
                :base-url="urlAjax" 
                :items='category.cards'
                :category-id='category.id'
                v-on:updated-cards="updateCardsCategory($event, category.id)">
                </draggable-cards-container>

            </div>
        </div>
    </div>
</template>

<script>

    import { Container, Draggable } from 'vue-smooth-dnd'
    // import models from './model/models'

    export default {  
        components: {Container, Draggable},
        props:{
            deck: {
            }, 
            urlAjax:{},
            baseUrl:{},
            author:{}
        },
        data: function () {
            return {
                allCategories: this.deck.categories,
            }
        },
        computed:{
        },
        mounted() {
        },
        methods:{
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

                var vueApp = this;
                var tempCategory = this.allCategories.find(
                    function(element) {
                      return element.id == categoryId;
                    }
                );

                axios.post(this.urlAjax + '/category/update', {
                  _token: $('meta[name=csrf-token]').attr('content'),
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
                  _token: $('meta[name=csrf-token]').attr('content'),
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
                  _token: $('meta[name=csrf-token]').attr('content'),
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
                  _token: $('meta[name=csrf-token]').attr('content'),
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
        flex-direction: column;
        width: 75vw;

        .deck{
            display: flex;
            flex-direction: row;
            margin-top: 1rem;
            padding: 2rem 0;
            position: relative;
            top: -2rem;

            .category{   
                border: solid 2px grey;
                margin-right: 2rem;
                position: relative;
                overflow:visible;   

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