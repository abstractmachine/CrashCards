<template>
    <div>
        <div class="mb-3">
            <button @click="createDeck"> New Deck </button>
        </div>

        <div class="decks-container">
            <div v-for="(deck, index) in allDecks" v-if="deck.author.id == author.id" :key="deck.id" class="deck-container">
        
                <button 
                    type="button" 
                    class="close" 
                    v-on:click="deleteDeck(index)"
                    v-if="deck.author.id == author.id" >
                  <span aria-hidden="true">&times;</span>
                </button>

                <a :href="urlAjax + '/' + deck.id " class="">
                    <h3 scope="row" >{{ deck.id }} {{ deck.name }}</h3>
                    <td>{{ deck.author.username}}</td>
                </a>

            </div>  
        </div>
    </div>
</template>

<script>

    export default {
        props:{
            decks: {
            }, 
            urlAjax:{},
            author:{}
        },
        data: function () {
            return {
                allDecks: this.decks,
                compareOrder: true,
                toCompare: '',
                search:"",
                newDeck:{}
            }
        },
        computed:{
        },
        mounted() {
        },
        methods:{
            orderBy: function(target){
                this.compareOrder = !this.compareOrder;     
                this.toCompare = target;
                this.allDecks.sort(this.compare);
            },
            compare: function(a,b) {
              if (a[this.toCompare] < b[this.toCompare])
                return this.compareOrder ? -1 : 1;
              if (a[this.toCompare] > b[this.toCompare])
                return this.compareOrder ? 1 : -1;
              return 0;
            },
            createDeck: function(){
                window.location = this.urlAjax + '/add';
            },
            deleteDeck: function(index){

                confirm("Sure to delete this deck?"); 

                this.toDelete = index;

                axios.post(this.urlAjax + '/remove', {
                  _token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                  _data: this.allDecks[index],
                })
                .then(response => {
                    console.log(response.data == true)
                    console.log(response.data)
                    if(response.data == true){
                        console.log("prout");
                        console.log(this.allDecks);
                        this.allDecks.splice(index,1);
                        console.log(this.allDecks);
                    }
                })
                .catch(e => {
                  console.log(e)
                })
            }

        }
    };
    
</script>


<style scoped lang="scss">
    .decks-container{
        display: flex;
        justify-content: center;
        align-items: stretch;
        flex-wrap: wrap;
        flex-direction: row;
        .deck-container{
            border: 4mm ridge rgba(170, 50, 220, .6);
            padding: 1rem;
            margin: 1rem;
            max-width: 30%;

            .close{
                float: right;
                margin: 1rem;
                border-color: red;
                border-radius: 100%;
            }
        }
    }

</style>