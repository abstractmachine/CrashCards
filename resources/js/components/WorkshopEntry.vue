<template>
    <div class="row">
        <div class="col">
            <div class="button-edit-mode mt-3 mb-3">
                <button class="btn btn-secondary" @click="editMode = true" v-if="!editMode"> Edit </button>
                <button class="btn btn-info" @click="editMode = false" v-if="editMode"> Finish Editing </button>
            </div>
            <div class="row">
                <div class="col">
                    <div class="input-group"  v-if="editMode">
                        <input type="text" class="form-control" v-model="workshop.name" v-on:focusout="updateWorkshop">
                    </div>  
                    <h2 v-if="!editMode">{{ workshop.name}}</h2>
                    <h5>{{ workshop.author.username }}</h5>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex align-items-baseline justify-content-start">
                    <h4 class=" mr-3">Deck : </h4>
                    <div class="deck-name" v-if="!editMode">
                        <p v-if="workshop.deck_id > 0">{{ workshop.deck_id }} {{ findDeck(workshop.deck_id) }}</p>
                        <p v-else> Passé en mode édit pour selectionner un deck.</p>
                    </div>
                    
                    <cool-select
                        v-model="deck"
                        :items="allDecks"
                        item-value="id"
                        item-text="name"
                        v-if="editMode"
                    />
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { CoolSelect } from 'vue-cool-select'

    export default {
        components: { CoolSelect },
        props:['workshop', 'urlAjax', 'author', 'decks'],
        data: function () {
            return {
                allDecks: this.decks,
                editMode: false,
                deck: null,
            }
        },
        watch:{
            deck: function(val){ 
               this.workshop.deck_id = this.deck;
               this.updateWorkshop();
            }
        },
        computed:{
        },
        mounted() {
            if(this.workshop.deck_id != null){
                this.deck = this.workshop.deck_id;
            }
        },
        methods:{
            updateWorkshop:function(){
                var vueApp = this;
                console.log('lo = ' + this.urlAjax + '/update');

                $.post(this.urlAjax + '/update' , {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    '_data': this.workshop,
                },function(data)
                {  
                    if(data == 'true')
                    {
                        console.log('success')
                    }
                    else{
                        console.log('failed')
                    }

                });
            },
            findDeck: function(deck){
                console.log(this.allDecks);
                for (var i = 0; i < this.allDecks.length; i++) {
                    if(this.allDecks[i].id = deck){
                        return this.allDecks[i].name;
                    }
                }
                return 'no deck';
            }
        }
    }
    
</script>


<style scoped lang="scss">



</style>