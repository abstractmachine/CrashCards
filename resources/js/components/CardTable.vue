<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="d-flex justify-content-start align-items-center">
                    <div class="form-group mr-3">
                        <div class="input-prepend">
                            <span class="input-icon">🔍</span>
                        </div>
                        <input type="text" v-model="search">
                    </div>

                    <div class="form-group" v-if="author != null">
                        <input type="checkbox" v-model="onlyMe">
                        <p>Only Mine</p>
                    </div>
                </div>
            </div>

            <table class="table mt-3">
              <thead>
                <tr>
                  <th scope="col" v-on:click="orderBy('id')">#</th>
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

                    if(card.name.match(this.search) || card.author.username.match(this.search)){
                        result = true;
                    }else if(card.subtitle != null){
                        if(card.subtitle.match(this.search)){
                            result = true;
                        }
                    }

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

            this.orderBy('id');
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

                if(this.newCard.name != null && this.newCard.author != null){

                    if(this.newCard.subtitle == null){
                        this.newCard.subtitle = ""
                    }

                    axios.post(this.urlAjax + '/add', {
                      _token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                      _data: this.newCard,
                    })
                    .then(response => {
                        if(response.data != 'null' || response.data != '0'){

                          this.newCard.id = response.data.id;
                          this.newCard.author = response.data.author;
                          this.newCard.editMode = false;
                          this.allCards.push(response.data);
                          this.cardsToUpdate.push(response.data);
                          this.newCard = {};

                          this.allCards.sort(this.compare);
                        }
                    })
                    .catch(e => {
                      console.log(e)
                    })
                }
            },
            updateCard: function(card){
                var vueApp = this;
                this.toUpdate = card;

                if(this.toUpdate.name != null != null && this.toUpdate.author != null){

                    if(this.newCard.subtitle == null){
                        this.newCard.subtitle = ""
                    }

                    axios.post(this.urlAjax + '/update', {
                      _token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                      _data: this.toUpdate,
                    })
                    .then(response => {
                        if(response.data != 'null' || response.data != '0' || response.data != 'false'){
                            var card = this.allCards[this.allCards.indexOf(this.toUpdate)];
                            card.name = response.data['name'];
                            card.subtitle = response.data.subtitle;
                            card.author = response.data.author;
                            this.toggleEditMode(card);
                        }
                    })
                    .catch(e => {
                      console.log(e)
                    })
                }
            },
            toggleEditMode:function(card){
                card = this.allCards[this.allCards.indexOf(card)];
                card.editMode = !card.editMode;

            },
            deleteCard: function(card){

                var vueApp = this;
                vueApp.toDelete = card;

                axios.post(this.urlAjax + '/remove', {
                  _token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                  _data: card,
                })
                .then(response => {
                    if(response.data == true){
                        var index = this.allCards.indexOf(this.toDelete);
                        this.allCards.splice(index,1);
                        this.cardsToUpdate.splice(index,1);
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

</style>