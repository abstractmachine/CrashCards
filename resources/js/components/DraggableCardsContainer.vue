<template>

    <Container @drop="onDrop" class="w-100 p-3 cards-container" group-name="cards-container">  
        <Draggable v-for='(item, key) in arrayItems' :key="key" class="border-dark border mb-3">

            <div class="draggable-item p-2 card">
                <button 
                    type="button" 
                    class="close" 
                    aria-label="Close" 
                    v-on:click="removeCard(item)" >
                  <span aria-hidden="true">&times;</span>
                </button>

                <div class="draggable-content">
                    <h5>{{categoryId}} ,{{key}} <span class="card-name">{{item.name}}</span></h5>
                    <h6> <span class="card-id">{{item.id}}</span> <span class="card-subtitle">{{item.subtitle}}</span></h6>
                </div>

            </div>

      </Draggable>

    </Container>

</template>

<script>

    import { Container, Draggable } from 'vue-smooth-dnd'
    // import models from './model/models'

    export default {  
        components: {Container, Draggable},
        props:['items', 'categoryId', 'baseUrl'],
        data: function () {
            return {
            }
        },
        computed:{
            arrayItems: function(){ 
                return Object.values(this.items)
            },
        },
        mounted() {
            // console.log(this.categoryId)
        },
        methods:{
            onDrop(dragResult) {
                var { removedIndex, addedIndex, payload } = dragResult

                if (removedIndex === null && addedIndex === null) {

                }else{

                    if (removedIndex !== null) 
                    {
                        this.arrayItems.splice(removedIndex, 1);
                    }

                    if (addedIndex !== null) {

                        var droppedElement = dragResult.droppedElement.getElementsByClassName('draggable-content')[0];
                        var cardId = parseInt(droppedElement.getElementsByClassName('card-id')[0].innerHTML);
                        this.saveCard(cardId, addedIndex);
                    }
                }
            },
            removeCard:function(target){                        
                var vueApp = this;

                if(target.pivot == null){
                    target.pivot = {};
                    target.pivot.id = target.pivotId;
                }

                vueApp.toDelete = target;

                $.post(this.baseUrl+ '/cards/detach/' + target.id + '/category/' + this.categoryId, {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                },function(data)
                {           
                    if(data === 'true')
                    {                
                        vueApp.arrayItems.splice(vueApp.arrayItems.indexOf(vueApp.toDelete), 1);
                        this.$emit('updated-cards', this.arrayItems) 
                    }
                }.bind(vueApp));
            },
            saveCard:function(id, addedIndex){                  
                var vueApp = this; 
                vueApp.indexToAdd = addedIndex;

                $.post(this.baseUrl+ '/cards/save/' + id + '/category/' + this.categoryId, {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                },function(data)
                {  
                    if(data !== 'false')
                    {              
                        vueApp.arrayItems.splice(vueApp.indexToAdd, 0, data);
                        this.$emit('updated-cards', this.arrayItems)  
                    }
                }.bind(vueApp));
            },
        }
    }
    
</script>


<style scoped lang="scss">

    .cards-container{
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: stretch;
        padding: 1rem;
        overflow-y: scroll;
        overflow-x: hidden;
        max-height: 500px;
        
        .smooth-dnd-draggable-wrapper{
            // text-align: center;
            overflow:visible;
            margin: 1rem 0;

            .card {
                position: relative;
                width: 90%;
                margin:auto;
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
        }
    }

</style>