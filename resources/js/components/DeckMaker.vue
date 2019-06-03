<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    
                    <div class="input-group">
                        <input type="text" class="form-control" v-model="deck.name" v-on:focusout="saveDeckName">
                    </div>  

                </div>
            </div>
            <div class="row deck-maker mt-3">
                <div class="col-4 border border-dark" v-for="(category, catKey) in allCategories" :key="catKey">
                    <button 
                        type="button" 
                        class="close " 
                        aria-label="Close" 
                        v-on:click="deleteCategory(category)" >
                      <span aria-hidden="true">&times;</span>
                    </button>

                    <div class="input-group">
                        <h5>category</h5>
                        <input type="text" class="form-control" v-model="category.name" v-on:focusout="saveCategoryName(category)">
                    </div>  

                    <draggable-cards-container 
                    :base-url="urlAjax" 
                    :items='category.cards'
                    :category-id='category.id'>
                    </draggable-cards-container>

                </div>

                <div class="col-2">
                    <button class="btn btn-dark mt-3" @click="addCategory"> add category </button>
                </div>

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
            saveCategoryName:function(category){
                var vueApp = this;
                category.deck_id = this.deck.id;
                console.log()
                // axios.post(this.urlAjax + '/remove', {
                //   _token: $('meta[name=csrf-token]').attr('content'),
                //   _data: category,
                // })
                // .then(response => {
                //     if(response.data == true){
                //         this.allDecks.splice(index,1);
                //     }
                // })
                // .catch(e => {
                //   console.log(e)
                // })
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
                        this.allCategories.push(response.data);
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
                        console.log(index);
                        this.allCategories.splice(index, 1);
                    }
                })
                .catch(e => {
                  console.log(e)
                })
            },
            saveDeckName:function(){
                var vueApp = this; 

                axios.post(this.baseUrl + '/decks/' + this.deck.id + '/update', {
                  _token: $('meta[name=csrf-token]').attr('content'),
                  _data: this.deck,
                })
                .then(response => {
                    // if(data === 'true')
                    // {
                    //     var index = vueApp.allCategories.indexOf(vueApp.toDelete);
                    //     vueApp.allCategories.splice(index, 1);
                    // }
                })
                .catch(e => {
                  console.log(e)
                })
            }

        }
    }
    
</script>


<style scoped lang="scss">

    .card {
      width: 150px;
      position: relative;

        .category-name{
            color: black;
            position: absolute;
            bottom: -40px;
            left: 0;
            width: 100%;
            text-align: center;
        }
    }


</style>