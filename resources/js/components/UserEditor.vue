<template>
    <div class="row">
        <div class="col">
            <div class="button-edit-mode mt-3 mb-3">
                <button class="btn btn-secondary" @click="editMode = true" v-if="!editMode"> Edit </button>
                <button class="btn btn-info" @click="editMode = false" v-if="editMode"> Finish Editing </button>
            </div>
            <div class="row deck-maker mt-3">
                <h1>user!</h1>
            </div>
        </div>
    </div>
</template>

<script>
    export default {  
        props:{
        },
        data: function () {
            return {
            }
        },
        computed:{
        },
        mounted() {
        },
        methods:{
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