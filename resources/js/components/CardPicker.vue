<template>
    <draggable
        class="dragArea card-picker card-container"
        :group="{ name: 'deck-cards', pull: 'clone', put: false }"
        draggable=".card" 
    >
        <transition-group>
            <div v-for="(card, key) in allCards" :key="key" class="card p-1">
                <h5> {{key}} <span class="card-name">{{card.name}}</span></h5>
                <h6> <span class="card-id">{{card.id}}</span> <span class="card-subtitle">{{card.subtitle}}</span></h6>
            </div>
        </transition-group>
    </draggable>

</template>

<script>

    export default {  
        props:['cards', 'baseUrl'],
        data: function () {
            return {
                allCards: this.cards,
            }
        },
        computed:{
        },
        mounted() {
            console.log(this.cards)
        },
        methods:{
            onDrop:function(){
                // console.log('ok') 
            }
        }
    }
    
</script>


<style scoped lang="scss">
    .card-container{
        width: 25vw;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

</style>