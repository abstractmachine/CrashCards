<template>
    <div class="row">
        <div class="col">

            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col" class="clickable" v-on:click="orderBy('name')">Title</th>
                  <!-- <th scope="col" v-on:click="orderBy('subtitle')">Subtitle</th> -->
                  <th scope="col" v-on:click="orderBy('author.name')">Author</th>
                  <th scope="col"  v-if="author != null">interaction</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if='author != null'>
                    <th scope="row" >X</th>
                    <td><input class="form-control" type="text" v-model="newDeck.name"></td>
                    <td><input class="form-control" type="text" :value="author.username" readonly></td>
                    <td><button class="btn btn-dark" type="button" v-on:click="addNewDeck">New Deck</button></td>
                </tr>

                <template v-for="(deck, key) in allDecks">
                    <tr>
                        <th scope="row" >{{ deck.id }}</th>
                        <th scope="row" >{{ deck.name }}</th>
                        <td>{{ deck.author.username}}</td>
                        <td v-if="author != null">
                            <div class="for-group" v-if="author.id == deck.author.id">
                                <button class="btn btn-dark" type="button" v-on:click="toggleEditMode(deck)">modify</button>
                                <button type="button" class="close" aria-label="Close" v-on:click="deleteDeck(deck)">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
              </tbody>
            </table>
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
            // for (var i = 0; i < this.allDecks.length; i++) {
            //     this.allDecks[i].editMode = false;
            //     this.cardsToUpdate.push(this.allDecks[i]);
            // }
        },
        methods:{
            // cardToUpdate: function(card){
            //    return this.cardsToUpdate[this.cardsToUpdate.indexOf(card)];
            // },
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
            addNewDeck: function(){
                var vueApp = this;

                if(this.author != null){
                    this.newDeck.author = this.author.id;
                }

                if(this.newDeck.name != null && this.newDeck.author != null){
                    $.post(this.urlAjax + '/add', {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        '_data': this.newDeck,
                    },function(data){  
                        console.log(data)
                        if(data != 'null' || data != '0'){

                          vueApp.allDecks.push(data);
                          vueApp.cardsToUpdate.push(data);
                          vueApp.newDeck = {};

                        }
                    }.bind(vueApp));
                }
            },
            updateDeck: function(card){
                // var vueApp = this;
                // this.toUpdate = card;

                // if(this.toUpdate.name != null && this.toUpdate.subtitle != null && this.toUpdate.author != null){
                //     $.post(this.urlAjax + '/update', {
                //         '_token': $('meta[name=csrf-token]').attr('content'),
                //         '_data': this.toUpdate,
                //     },function(data){  
                //         // console.log(data)
                //         if(data != 'null' || data != '0' || data != 'false'){
                //             var card = vueApp.allDecks[vueApp.allDecks.indexOf(vueApp.toUpdate)];
                //             console.log(vueApp.toUpdate)
                //             card.name = data['name'];
                //             card.subtitle = data.subtitle;
                //             card.author = data.author;
                //             this.toggleEditMode(card);
                //         }
                //     }.bind(vueApp));
                // }
            },
            toggleEditMode:function(card){

                // console.log(card)
                // card = this.allDecks[this.allDecks.indexOf(card)];
                // card.editMode = !card.editMode;

            },
            deleteDeck: function(card){

                // var vueApp = this;
                // vueApp.toDelete = card;

                // $.post(this.urlAjax + '/remove', {
                //     '_token': $('meta[name=csrf-token]').attr('content'),
                //     '_data': card,
                // },function(data){  
                //     console.log(data)
                //     if(data === 'true'){
                //         var index = vueApp.allDecks.indexOf(vueApp.toDelete);
                //         console.log('index = ' + index)
                //         vueApp.allDecks.splice(index,1);
                //         vueApp.cardsToUpdate.splice(index,1);
                //     }
                // }.bind(vueApp));
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