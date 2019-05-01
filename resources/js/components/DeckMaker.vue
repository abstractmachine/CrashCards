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
            <div class="row deck-maker">
                <div class="col-4 border border-dark" v-for="(category, catKey) in allCategories" :key="catKey">
                    <button 
                        type="button" 
                        class="close" 
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
                    :category-id='category.id'></draggable-cards-container>

                </div>

                <div class="col-2">
                    <button class="btn btn-dark" @click="addCategory"> add category </button>
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
                // items: ['ok1', 'ok2', 'ok3']
            }
        },
        computed:{
        },
        mounted() {
            // for (var i = 0; i < this.allCategories.length; i++) {
            //     // this.allCategories[i]
            // }
        },
        methods:{
            saveCategoryName:function(category){
                var vueApp = this;
                category.deck_id = this.deck.id;

                $.post(this.baseUrl + '/categories/' + category.id + '/save/name' , {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    '_data': category,
                },function(data)
                {  
                    if(data !== null)
                    {
                        category = data;
                    }
                }.bind(category));
            },
            addCategory: function(){
                var vueApp = this;

                $.post(this.urlAjax + '/addcategory', {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    '_data': this.deck,
                },function(data)
                {  
                    console.log('success')
                    if(data !== null)
                    {   
                        vueApp.allCategories.push(data);
                    }
                }.bind(vueApp));
            },
            deleteCategory: function(category){

                var vueApp = this;
                vueApp.toDelete = category;    

                $.post(this.baseUrl + '/categories/' + category.id + '/delete', {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    '_data': this.deck,
                },function(data){  
                    console.log('success')
                    if(data === 'true')
                    {
                        var index = vueApp.allCategories.indexOf(vueApp.toDelete);
                        vueApp.allCategories.splice(index, 1);
                    }
                }.bind(vueApp));
            },
            saveDeckName:function(){

                // var vueApp = this;
                // vueApp.toDelete = category;    

                // $.post(this.baseUrl + '/categories/' + category.id + '/delete', {
                //     '_token': $('meta[name=csrf-token]').attr('content'),
                //     '_data': this.deck,
                // },function(data){  
                //     console.log('success')
                //     if(data === 'true')
                //     {
                //         var index = vueApp.allCategories.indexOf(vueApp.toDelete);
                //         vueApp.allCategories.splice(index, 1);
                //     }
                // }.bind(vueApp));
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