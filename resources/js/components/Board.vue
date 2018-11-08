<template>
    <div class="row justify-content-left">
        <div class="col-3">
            <div class="flex-row">
                <h3 v-on:click="alert('ok')">picked pile:</h3>
                <div v-for="card in drawPile" 
                    class="card border d-flex justify-content-center align-items-center"
                    :style="'background:' +  card.category.background_color+ '; color:' + card.category.color">
                    <p>{{card.title}}</p>
                    <p>{{card.subtitle}}</p>
                    <p class="category-name">{{card.category.name}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            deck: {
                type: Object
            }
        },
        data: function () {
            return {
                drawPile: [],
                pickedPile: [],
                unsusedPile:[]
            }
        },
        mounted() {

            for (var i = 0; i < this.deck.cards.length; i++) {

                console.log(this.deck.cards[i].pivot)
                var  newCard = {};

                newCard.title = this.deck.cards[i].name;
                newCard.subtitle = this.deck.cards[i].subtitle;
                newCard.category = this.findCategory(this.deck.cards[i].pivot.category_id);

                this.drawPile.push(newCard)

            }
        },
        methods:{
            findCategory: function(id){
                for(var i = 0, length1 = this.deck.categories.length; i < length1; i++){
                    if (this.deck.categories[i].id == id) {
                        return this.deck.categories[i];
                    }
                }
                return false;
            }
        }
    }
</script>


<style scoped  lang="scss">

    .card {
      width: 150px; height: 300px;
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