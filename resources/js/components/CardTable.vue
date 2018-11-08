<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                        
                      <input type="text" v-model="search">
                    </div>
                    <div class="form-group" v-if="author != null">
                        <input type="checkbox" v-model="onlyMe">
                        <p>Only Mine</p>
                    </div>
                </div>
            </div>

            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col" class="clickable" v-on:click="orderBy('name')">Title</th>
                  <th scope="col" v-on:click="orderBy('subtitle')">Subtitle</th>
                  <th scope="col" v-on:click="orderBy('author.name')">Author</th>
                  <th scope="col"  v-if="author != null">interaction</th>
                </tr>
              </thead>
              <tbody>

                <tr v-if='author != null'>
                    <th scope="row" >X</th>
                    <td><input class="form-control" type="text" v-model="newCard.name"></td>
                    <td><input class="form-control" type="text" v-model="newCard.subtitle"></td>
                    <td><input class="form-control" type="text" :value="author.username" readonly></td>
                    <td><button class="btn btn-dark" type="button" v-on:click="addNewCard">Add Card</button></td>
                </tr>

                <template v-for="(card, key) in filteredCards">
                    <tr v-if="!card.editMode">
                        <th scope="row" >{{ card.id }}</th>
                        <td>{{ card.name }}</td>
                        <td>{{ card.subtitle }}</td>
                        <td>{{ card.author.username}}</td>
                        <td v-if="author != null">
                            <div class="for-group" v-if="author.id == card.author.id">
                                <button class="btn btn-dark" type="button" v-on:click="toggleEditMode(card)">modify</button>
                                <button type="button" class="close" aria-label="Close" v-on:click="deleteCard(card)">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr v-else>
                        <th scope="row" > {{cardToUpdate(card).id}}</th>
                        <td><input class="form-control" type="text" v-model="cardToUpdate(card).name"></td>
                        <td><input class="form-control" type="text" v-model="cardToUpdate(card).subtitle"></td>
                        <td><input class="form-control" type="text" :value="author.username " readonly></td>
                        <td>
                            <button class="btn btn-dark" type="button" v-on:click="updateCard(cardToUpdate(card))">Update</button>
                            <button type="button" class="close" aria-label="Close" v-on:click="toggleEditMode(cardToUpdate(card))">
                              <span aria-hidden="true">&times;</span>
                            </button>
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
            cards: {
            }, 
            urlAjax:{},
            author:{},
        },
        data: function () {
            return {
                allCards: this.cards,
                newCard:{},
                cardsToUpdate: [],
                toUpdate:{},
                compareOrder: true,
                onlyMe: true,
                toCompare: '',
                search:"",
            }
        },
        computed:{
            filteredCards: function(){
                return this.allCards.filter((card) =>{
                    var result = false; 
                    if(card.name.match(this.search) || card.subtitle.match(this.search) || card.author.username.match(this.search))
                        result = true;
                    if(this.onlyMe && this.author != null)
                    {
                        if (this.author.id != card.author.id)
                            result = false;
                    }
                    return result;
                })
            }
        },
        mounted() {
            for (var i = 0; i < this.allCards.length; i++) {
                this.allCards[i].editMode = false;
                this.cardsToUpdate.push(this.allCards[i]);
            }
        },
        methods:{
            cardToUpdate: function(card){
               return this.cardsToUpdate[this.cardsToUpdate.indexOf(card)];
            },
            orderBy: function(target){
                this.compareOrder = !this.compareOrder;     
                this.toCompare = target;
                this.allCards.sort(this.compare);
            },
            compare: function(a,b) {
              if (a[this.toCompare] < b[this.toCompare])
                return this.compareOrder ? -1 : 1;
              if (a[this.toCompare] > b[this.toCompare])
                return this.compareOrder ? 1 : -1;
              return 0;
            },
            addNewCard: function(){
                var vueApp = this;

                if(this.author != null){
                    this.newCard.author = this.author.id;
                }

                if(this.newCard.name != null && this.newCard.subtitle != null && this.newCard.author != null){
                    $.post(this.urlAjax + '/add', {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        '_data': this.newCard,
                    },function(data){  
                        // console.log(data)
                        if(data != 'null' || data != '0'){

                          vueApp.newCard.id = data.id;
                          vueApp.newCard.author = data.author;
                          vueApp.newCard.editMode = false;
                          vueApp.allCards.push(data);
                          vueApp.cardsToUpdate.push(data);
                          vueApp.newCard = {};

                        }
                    }.bind(vueApp));
                }
            },
            updateCard: function(card){
                var vueApp = this;
                this.toUpdate = card;

                if(this.toUpdate.name != null && this.toUpdate.subtitle != null && this.toUpdate.author != null){
                    $.post(this.urlAjax + '/update', {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        '_data': this.toUpdate,
                    },function(data){  
                        // console.log(data)
                        if(data != 'null' || data != '0' || data != 'false'){
                            var card = vueApp.allCards[vueApp.allCards.indexOf(vueApp.toUpdate)];
                            console.log(vueApp.toUpdate)
                            card.name = data['name'];
                            card.subtitle = data.subtitle;
                            card.author = data.author;
                            this.toggleEditMode(card);
                        }
                    }.bind(vueApp));
                }
            },
            toggleEditMode:function(card){

                console.log(card)
                card = this.allCards[this.allCards.indexOf(card)];
                card.editMode = !card.editMode;

            },
            deleteCard: function(card){

                var vueApp = this;
                vueApp.toDelete = card;

                $.post(this.urlAjax + '/remove', {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    '_data': card,
                },function(data){  
                    console.log(data)
                    if(data === 'true'){
                        var index = vueApp.allCards.indexOf(vueApp.toDelete);
                        console.log('index = ' + index)
                        vueApp.allCards.splice(index,1);
                        vueApp.cardsToUpdate.splice(index,1);
                    }
                }.bind(vueApp));
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