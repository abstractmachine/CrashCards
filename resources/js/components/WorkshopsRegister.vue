<template>
    <div class="row">
        <div class="col">
            <div class="row mb-3">
                <div class="col">
                  <button class="btn btn-dark" @click="createWorkshop"> Add Workshop </button>
                </div>

            </div>

            
            <div class="row">
                <div class="col">
                    <h2>Mes workshops:</h2>
                </div>
            </div>

            <div class="row">
                <div v-for="(workshop, index) in userWorkshop"  :key="workshop.id" class="p-3 w-100 border col-3 workshop border-light ">
            
                    <button 
                        type="button" 
                        class="close" 
                        aria-label="Close" 
                        v-on:click="deleteWorkshop(workshop.id, index)"
                        v-if="workshop.author.id == user.id" >
                      <span aria-hidden="true">&times;</span>
                    </button>

                    <a :href="baseUrl + '/' + workshop.id " class="">
                        <h3 scope="row" >{{ workshop.id }} {{ workshop.name }}</h3>
                        <td>{{ workshop.author.username }}</td>
                    </a>

                </div>  

                <div class="col" v-if="userWorkshop.lenght == 0">
                    <p>Aucun workshop</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <hr>
                    <h2>Tout les workshops:</h2>
                </div>
            </div>

            <div class="row">
                <div v-for="(workshop, index) in allWorkshops"  :key="workshop.id" v-if="workshop.author.id != user.id" class="p-3 w-100 border col-3 workshop border-light ">
                    <a :href="baseUrl + '/' + workshop.id " class="">
                        <h3 scope="row" >{{ workshop.id }} {{ workshop.name }}</h3>
                        <td>{{ workshop.author.username }}</td>
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