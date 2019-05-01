<template>
    <div class="row">
        <div class="col">
            <div class="row mb-3">
                <div class="col">
                  <button class="btn btn-dark" @click="createWorkshop"> Add deck </button>
                </div>

            </div>

            <div class="row">
                <div v-for="(workshop, index) in allWorkshops"  :key="workshop.id" class="p-3 w-100 border col-3 workshop border-light ">
            
                    <button 
                        type="button" 
                        class="close" 
                        aria-label="Close" 
                        v-on:click="deleteWorkshop(index)"
                        v-if="workshop.author.id == author.id" >
                      <span aria-hidden="true">&times;</span>
                    </button>

                    <a :href="urlAjax + '/' + workshop.id " class="">
                        <h3 scope="row" >{{ workshop.id }} {{ workshop.name }}</h3>
                        <td>{{ workshop.author.username}}</td>
                    </a>

                </div>  
            </div>

        </div>
    </div>
</template>

<script>

    export default {
        props:{
            workshops: {
            }, 
            urlAjax:{},
            author:{}
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
        },
        mounted() {
        },
        methods:{
            // orderBy: function(target){
            //     this.compareOrder = !this.compareOrder;     
            //     this.toCompare = target;
            //     this.allWorkshops.sort(this.compare);
            // },
            // compare: function(a,b) {
            //   if (a[this.toCompare] < b[this.toCompare])
            //     return this.compareOrder ? -1 : 1;
            //   if (a[this.toCompare] > b[this.toCompare])
            //     return this.compareOrder ? 1 : -1;
            //   return 0;
            // },
            createWorkshop: function(){
                window.location = this.urlAjax + '/add';
            },
            deleteWorkshop: function(index){

                confirm("Sure to delete this workshop?"); 

                var vueApp = this;
                vueApp.toDelete = index;

                $.post(this.urlAjax + '/remove', {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    '_data': this.allWorkshops[index],
                },function(data){  
                    console.log(data)

                    if(data === 'true'){
                        vueApp.allWorkshops.splice(vueApp.toDelete,1);
                        console.log(vueApp)
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