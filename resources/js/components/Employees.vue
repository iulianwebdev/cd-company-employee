<template>
    <div class="box">
    <div class="box-header">
        <h3 class="box-title">Hover Data Table</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
        <thead>
            <sort-by 
                v-bind:columns="columns"  
                v-bind:disable-on="['company', 'actions']"
                v-on:sort="sort"></sort-by>
        </thead>
        <tbody>
            <tr role="row" v-for="(employee, index) in allEmployees" :class="{'odd': index % 2 === 0, 'even': index % 2 !== 0}" v-bind:key="employee.id">
                <td class="sorting_1">{{employee.first_name}}</td>
                <td>{{employee.last_name}}</td>
                <td>{{employee.email}}</td>
                <td>{{employee.phone}}</td>
                <td>{{employee.company}}</td>
                <td>
                    <button class="btn btn-primary btn-flat pull-right">Edit</button>
                    <button class="btn btn-danger btn-flat pull-right" v-on:click="openDeletePrompt(employee)">Delete</button>
                </td>
            </tr>
        </tbody>
        <tfoot v-if="columnLabels.length">
            <tr>
                <th rowspan="1" colspan="1" v-for="(col, key) in columnLabels" v-bind:key="key">
                    {{col}}
                </th>
            </tr>
            </tfoot>
        </table>
        </div>
        </div>

        <paginator-vue v-bind:pager-data="pagerData" v-on:paginate="paginate"></paginator-vue>
        </div>
    </div>

     <modal 
        v-on:close="abortDelete" 
        v-on:action="deleteEmployee" 
        v-show="modalVisible" 
        v-bind:loading="showLoader"
        v-bind:type="'danger'" 
        v-bind:save="true"
        >
            <template v-slot:header>Are you sure you want to delete this Employee?</template>
            <template v-slot> 
                <h3>Employee to delete: <strong>{{employeeToDelete.first_name}} {{employeeToDelete.last_name}}</strong></h3>
            </template>
            <template v-slot:action>Delete</template>
        </modal>
    </div>
    <!-- /.box-body -->

</template>

<script>
import http from '../services/http';
import { SET_EMPLOYEES, EMPLOYEES } from '../store/constants'
import { getEmployees } from '../services/http';
import { mapGetters } from 'vuex'

import sortMixin from '../mixins/sort'
import paginateMixin from '../mixins/paginate'
import modalMixin from '../mixins/modal'

export default {
    name: 'employees',
    data(){
        return {
            columns: {
                first_name: 'First name', 
                last_name: 'Last name',
                email: 'Email',
                phone: 'Phone',
                company: 'Company',
                actions: 'Actions'
            },
            editMode:false,
            employeeToDelete: {}
        }
    },
    props: {
        companyId: {
            type: Number|String,
            required: true
        }
    },
    mixins: [sortMixin, paginateMixin, modalMixin],
    computed: {
        ...mapGetters(
           {getEmployees: EMPLOYEES}
       ),
        columnLabels(){
            return Object.values(this.columns) || [];
        },
        allEmployees() {
            return this.getEmployees(this.companyId)
        }
    },
    methods: {
        get(){
            let args = [this.companyId];
            args = this.buildPaginationParams(args)
            args = this.buildSortParams(args)

            http.getEmployees(...args).then(({data}) => {
                // debugger
                if (data.meta) {
                    this.updatePagination(data.meta)
                }
                if(data.data.length) {
                    this.$store.commit(SET_EMPLOYEES, {companyId:this.companyId, data: data.data})
                }
            }, error => {
                console.log(error)
            })
        },
        deleteEmployee(){
            this.loading()
            let { company_id, id } = this.employeeToDelete
            http.deleteEmployee(company_id, id).then(response => {
                this.stopLoading()
                this.get()
                this.closeModal()
            }, error => {
                this.stopLoading()
                this.closeModal()
                
            })
        },
        abortDelete(){
            this.employeeToDelete = {}
            this.closeModal()
        },
        openDeletePrompt(employee) {
            this.employeeToDelete = employee
            this.showModal()
        }
    },
    created(){
        this.get()
    }
}
</script>

