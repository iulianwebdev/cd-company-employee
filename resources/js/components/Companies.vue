<template>
    <div class="companies-wrapper">
        <div class="actions">
            <router-link :to="{name: 'dashboard'}"><i class="fa fa-arrow-left"></i></router-link>
            <button class="btn btn-primary pull-right" v-on:click="add">
                <i class="fa fa-plus"></i> Add
            </button>
        </div>
        <div class="list-group">
            <a v-on:click="gotoCompany(company.id)" class="list-group-item" v-for="company in companies" v-bind:key="company.id">
                <span class="badge">Employees: {{ company.employee_count }}</span>
                <span class="small-logo"><img :src="(company.logo ? BASE_PATH+company.logo : THUMB_PATH)" :alt="company.name"></span>
                <strong>{{company.name}}</strong>
            </a> 
        </div>


        <modal v-on:close="closeModal" v-show="modalVisible" :save="false">
            <template v-slot:header>Create New Company</template>
            <template v-slot> 
                <create-form type='company' :fields="newCompanyFields" v-on:close="closeModal"></create-form>
            </template>
        </modal>

    </div>
</template>

<script>
    import http from '../services/http'
    import pathMixin from '../mixins/paths'
    import modalMixin from '../mixins/modal'
    import sortMixin from '../mixins/sort'
    import paginateMixin from '../mixins/paginate'
    import {
        SET_COMPANIES,
        SET_COMPANY,
        COMPANIES
    } from '../store/constants'
    import {mapGetters} from 'vuex'
    export default {
        name:'companies',
        data() {
            return {
                modalVisible: false,
                newCompanyFields: ['name', 'email', 'website', 'logo']
            }
        },
        computed: {
            ...mapGetters(
                {companies: COMPANIES}
            )
        },
        mixins:[pathMixin, modalMixin, sortMixin, paginateMixin],
        watch: {
            $route:'get'
        },
        methods: {
            get(){
                http.getAllCompanies().then(({data}) => {
                    this.$store.commit(SET_COMPANIES, data)
                }, error => {
                    console.log(error)
                })
            },
            add(){
                // coming from mixin
                this.showModal();
            },
            gotoCompany(id){
                this.$router.push({'name': 'company', params: {id}})
            }
        },
        created(){
            this.get()

        },
        mounted() {
            console.log('Companies mounted.')
        },
}
</script>

<style lang="scss" scoped>
    .small-logo {
        height: 100px;
        width: 126px;
        display: inline-block;
        text-align: center;
        background: #fffafa;
        padding: 5px;
        border: 1px solid #eee;
        margin-right: 10px;

        img {
            width: auto;
            max-height: 100%;
            max-width: 100%;
        }
    }
    .companies-wrapper {
        .list-group-item {
            cursor:pointer;
            strong {
                font-size: 1.3em
            }
        }
    }
</style>
