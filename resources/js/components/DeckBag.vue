<template>
    <div class="row">
        <div class="col">
            <div class="row mb-3">
                <div class="col">
                  <button class="btn btn-dark" @click="createDeck"> Add deck </button>
                </div>

            </div>

            <div class="row">
                <div v-for="(deck, index) in allDecks"  :key="deck.id" class="p-3 w-100 border col-3 deck border-light ">
            
                    <button 
                        type="button" 
                        class="close" 
                        aria-label="Close" 
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

            <modal name="hello-world">
              hello, world!
            </modal>
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
                  _token: $('meta[name=csrf-token]').attr('content'),
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
    }
    
</script>


<style scoped lang="scss">

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