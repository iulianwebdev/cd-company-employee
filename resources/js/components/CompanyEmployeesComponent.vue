<template>
    <div class="company-employees-wrapper">
        <div class="list-group">
            <a v-on:click="gotoEmployeePage(employee.id)" class="list-group-item" v-for="employee in employees" v-bind:key="employee.id">
                
                <strong>{{ employee.name }}</strong>
            </a> 
        </div>

        <div class="col-xs-12 text-center">
            <button class="btn btn-app" v-on:click="add">
                <i class="fa fa-plus"></i> Add
            </button>
        </div>

        <modal v-on:close="closeModal" v-show="modalVisible" :save="false">
            <template v-slot:header>Create New Company</template>
            <template v-slot> 
                <create-form :company-id="+companyId" type='employee' :fields="newEmployeeFields" v-on:close="closeModal"></create-form>
            </template>
        </modal>
    </div>
</template>

<script>
    import http from '../services/http'
    import pathMixin from '../mixins/paths'
    import modalMixin from '../mixins/modal'
    import {
        SET_EMPLOYEES, COMPANY_EMPLOYEES
    } from '../store/constants'
    import {mapGetters} from 'vuex'
    export default {
        name:'companies-employee',
        data() {
            return {
                modalVisible: false,
                newEmployeeFields: [
                    'first_name', 
                    'last_name',
                    'email',
                    'phone'
                    ]
            }
        },
        props:['companyId'],
        mixins:[pathMixin, modalMixin],
        computed: {
            ...mapGetters(
                {companyEmployees: COMPANY_EMPLOYEES}
            ),
            employees(){
                this.companyEmployees(+this.companyId)
            }
        },
        watch: {
            $route:'get'
        },
        methods: {
            get(){
                http.getEmployees(this.companyId).then(({data}) => {
                    if(data.data.length) {
                        this.$store.commit(SET_EMPLOYEES, {companyId:this.companyId, data: data.data})
                    }
                }, error => {
                    console.log(error)
                })
            },
            add(){
                // coming from mixin
                this.showModal();
            },
            gotoEmployeePage(id) {
                this.$router.push({'name': 'employee', params: { id }})
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
