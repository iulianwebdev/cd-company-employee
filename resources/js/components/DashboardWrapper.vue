<template>
    <div class="col-xs-12">
        <div class="row justify-content-center">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    // import CompaniesComponentVue from './CompaniesComponent.vue';
    export default {
        name:'wrapper',
        components:{
            // [CompaniesComponentVue.name]: CompaniesComponentVue
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
