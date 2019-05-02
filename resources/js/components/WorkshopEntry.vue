<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control" v-model="workshop.name" v-on:focusout="updateWorkshop">
                    </div>  
                    <h5>{{ workshop.author.username }}</h5>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Deck</h4>
                    <p>{{ workshop.deck_id }}</p>
                    
                    <cool-select
                        v-model="workshop.deck_id"
                        :items="allDecks"
                        item-value="id"
                        item-text="name"
                    />
                   <!--  <input type="text" class="form-control" v-model="workshop.deck" v-on:focusout="updateWorkshop" list="decks">
                    
                    <datalist id="decks">
                      <option :value="deck.name" v-for="deck in decks"></option>
                    </datalist> -->
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
                allDecks: this.decks
            }
        },
        computed:{
        },
        mounted() {
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
        }
    }
    
</script>


<style scoped lang="scss">



</style>