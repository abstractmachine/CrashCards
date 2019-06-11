<template>
    <draggable 
        v-model="arrayItems" 
        draggable=".card" 
        group="deck-cards"
        class="draggable-zone">
        <transition-group>

            <div v-for="(item, key) in arrayItems" :key="key" class="p-2 card">
                <button 
                    type="button" 
                    class="close" 
                    aria-label="Close" 
                    v-on:click="removeCard(item)" >
                  <span aria-hidden="true">&times;</span>
                </button>

                <div class="draggable-content">
                    <span class="card-name">{{item.name}}</span></h5>
                    <h6> <span class="card-id">{{item.id}}</span> <span class="card-subtitle">{{item.subtitle}}</span></h6>
                </div>
            </div>

            <div class="card empty-card" v-if="arrayItems.length==0" :key="arrayItems.length + 1" >
                EMPTY
            </div>

        </transition-group>


    </draggable>

</template>

<script>
    export default {  
        components:{
        },
        props:['items', 'categoryId', 'baseUrl'],
        data: function () {
            return {
            }
        },
        computed:{
            arrayItems: {
                get: function () {
                    return Object.values(this.items)
                },
                set: function (newCards) {
                    this.$emit('updated-cards', newCards)  
                }
            }
        },
        mounted() {
        },
        methods:{
            removeCard:function(target){      
                this.arrayItems.splice(this.arrayItems.indexOf(this.toDelete), 1);
                this.$emit('updated-cards', this.arrayItems)         
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
        min-height: 100px;
        
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