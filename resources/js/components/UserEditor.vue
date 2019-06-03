<template>
    <div class="row">
        <div class="col pb-3">
            <div class="button-edit-mode mt-3 mb-3">
                <button class="btn btn-secondary" @click="editMode = true" v-if="!editMode"> Edit </button>
                <button class="btn btn-info" @click="editMode = false" v-if="editMode"> Finish Editing </button>
            </div>
            <div class="row deck-maker mt-3">
                <div class="col">
                    <h1>user!</h1>
                    <div class="d-flex align-items-baseline">
                        <h3 class="mr-3">Name: </h3>
                        <input type="text" class="form-control" v-model="modifiedUser.name" v-on:focusout="updateUser" v-if="editMode">
                        <h3 v-if="!editMode">{{ modifiedUser.name }}</h3>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h3 class="mr-3">Username: </h3>
                        <input type="text" class="form-control" v-model="modifiedUser.username" v-on:focusout="updateUser" v-if="editMode">
                        <h3 v-if="!editMode">{{ modifiedUser.username }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {  
        props:{
            user: {
                type: Object,
            },
            urlAjax: {
                type: String,
            }
        },
        data: function () {
            return {
                editMode: false,
                modifiedUser: this.user,
            }
        },
        computed:{
        },
        mounted() {
            // this.modifiedUser = this.user;
        },
        methods:{
            updateUser: function(){
                axios.post(this.urlAjax, {
                  _token: $('meta[name=csrf-token]').attr('content'),
                  _data: this.modifiedUser,
                })
                .then(response => {
                    this.modifiedUser = response.data;
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
      width: 150px;
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