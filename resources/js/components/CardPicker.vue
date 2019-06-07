<template>
    <Container @drop="onDrop" class="card-picker" group-name="cards-container">   
        <h3>Cartes :</h3>
        <Draggable class="card-container w-100" v-for="(card, key) in cards"  :key="key">

            <div class="card draggable-item">
             <!--  <h5>{{card.id}} {{card.name}}</h5>
              <h6>{{card.subtitle}}</h6> -->
            
                <div class="draggable-content p-1">
                    <h5> {{key}} <span class="card-name">{{card.name}}</span></h5>
                    <h6> <span class="card-id">{{card.id}}</span> <span class="card-subtitle">{{card.subtitle}}</span></h6>
                </div>
            </div>

        </Draggable>
    </Container>

</template>

<script>

    import { Container, Draggable } from 'vue-smooth-dnd'

    export default {  
        components: {Container, Draggable},
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