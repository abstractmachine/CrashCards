<template>
    <div class="">
        <div class="d-flex justify-content-start align-content-center">
          <h3 class="mr-3">Workshops:</h3>
          <button class="" @click="createWorkshop"> Add Workshop </button>
        </div>

            
        <div>
            <h2>Mes workshops:</h2>
            <div class="workshops-container">
                <a v-for="(workshop, index) in userWorkshop"  :key="workshop.id" :href="baseUrl + '/' + workshop.id ">
                    <div class="workshop" >
                        <button 
                            type="button" 
                            class="close" 
                            aria-label="Close" 
                            v-on:click="deleteWorkshop(workshop.id, index)"
                            v-if="workshop.author.id == user.id" >
                          <span aria-hidden="true">&times;</span>
                        </button>

                        <h3 scope="row" >{{ workshop.id }} {{ workshop.name }}</h3>
                        <td>{{ workshop.author.username }}</td>
                    </div>

                </a>  

                <div class="col" v-if="userWorkshop.lenght == 0">
                    <p>Aucun workshop</p>
                </div>
            </div>
        </div>


        <div>
            <hr>
            <h2>Tout les workshops:</h2>
            <div class="workshops-container">
                <a :href="baseUrl + '/' + workshop.id "  v-for="(workshop, index) in allWorkshops"  :key="workshop.id" v-if="workshop.author.id != user.id" class="p-3">
                    <div class="workshop">
                        <h3 scope="row" >{{ workshop.id }} {{ workshop.name }}</h3>
                        <td>{{ workshop.author.username }}</td>
                    </div>
                </a>  
            </div>
        </div>

        </div>
    </div>
</template>

<script>

    export default {
        props:{
            workshops: Array, 
            baseUrl: String,
            removeUrl: String,
            user: Object
        },
        data: function () {
            return {
                allWorkshops: this.workshops,
                compareOrder: true,
                toCompare: '',
                search:"",
                newDeck:{}
            }
        },
        computed:{
            userWorkshop: function(){
                var selectedWorkshops = [];
                for (var i = 0; i < this.allWorkshops.length; i++) {
                    if(this.user.id == this.allWorkshops[i].author.id){
                        selectedWorkshops.push(this.allWorkshops[i]);
                    }
                }
                return selectedWorkshops;
            }
        },
        mounted() {
        },
        methods:{
            createWorkshop: function(){
                window.location = this.baseUrl + '/add';
            },
            deleteWorkshop: function(workshopId, index){

                confirm("Sure to delete this workshop?"); 

                var vueApp = this;

                axios.post(this.baseUrl + '/' + workshopId + '/remove', {
                  _token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                })
                .then(response => {
                    console.log(response.data);
                    if(response.data != 'false'){
                        this.allWorkshops.splice(this.getIndexWorkshop(response.data),1);
                    }
                })
                .catch(e => {
                  console.log(e)
                })
            },
            getIndexWorkshop: function(id){
                let index = -1;

                for (var i = 0; i < this.allWorkshops.length; i++) {
                    if(this.allWorkshops[i].id == id){
                        index = i;
                    }
                }
                return index;
            }

        }
    }
    
</script>


<style scoped lang="scss">
    .workshops-container{
        display: flex;
        justify-content: flex-start;
        flex-wrap: nowrap;

        .workshop{
            margin: 1rem;
            padding: 1rem;
            flex-grow: 1;
            border: 9px groove #A48F99;
            border-radius: 40px;
            background-color: rgb(230,230,230);
        }
    }
</style>