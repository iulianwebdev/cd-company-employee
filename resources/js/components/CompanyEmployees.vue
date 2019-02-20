<template>
    <div class="company-employees-wrapper">
    <div class="actions">
         
        <router-link :to="{name: 'company', params:{id: companyId}}"><i class="fa fa-arrow-left"></i></router-link>
        <button class="btn btn-primary pull-right" v-on:click="add">
            <i class="fa fa-plus"></i> Add
        </button>
    </div>
    
        <!-- <div class="list-group" v-if="employees.length">
            <a v-on:click="gotoEmployeePage(employee.id)" class="list-group-item" v-for="employee in employees" v-bind:key="employee.id">
                
                <strong>{{ employee.first_name }}</strong>
                <strong>{{ employee.last_name }}</strong>
            </a> 
        </div> -->
        <employees v-bind:companyId="companyId"></employees>
        



        <modal v-on:close="closeModal" v-show="modalVisible" :save="false">
            <template v-slot:header>Add New Employee</template>
            <template v-slot> 
                <create-form :company-id="+companyId" type='employee' :fields="newEmployeeFields" v-on:close="closeAction"></create-form>
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
        SET_EMPLOYEES, COMPANY_EMPLOYEES
    } from '../store/constants'
    import {mapGetters} from 'vuex'
    import Employees from './Employees';
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
        components:{
            [Employees.name]: Employees
        },
        mixins:[pathMixin, modalMixin, sortMixin, paginateMixin],
        computed: {
            ...mapGetters(
                {companyEmployees: COMPANY_EMPLOYEES}
            ),
            employees(){
                return this.companyEmployees(+this.companyId) || []
            }
        },
        watch: {
            $route:'get'
        },
        methods: {
            get(){
                http.getEmployees(this.companyId).then(({data}) => {
                    // debugger
                    if(data.data.length) {
                        console.log('trigger commit')
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
            },
            closeAction(){
                // doesn't matter that they race
                this.get()
                this.closeModal()
            }
        },
        created(){
            
        },
        mounted() {
            this.get()
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
