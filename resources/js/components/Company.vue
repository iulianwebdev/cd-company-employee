<template>
    <div class="company-wrapper">
        <div class="box box-widget widget-user-2" v-if="company && company.id">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow" >
              <div class="widget-user-image">
                <img class="img-circle" :src="(company.logo ? BASE_PATH+company.logo : THUMB_PATH)" :alt="company.name">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">{{company.name}}</h3>
              <h5 class="widget-user-desc">{{company.website}}</h5>
              <h4 class="panel-title pull-right">{{company.email}}</h4>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><router-link :to="{name:'company-employees', params:{ companyId:company.id }}">Employees <span class="pull-right badge bg-blue">{{company.employee_count}}</span></router-link></li>
                <li class="actions">
                    <div v-if="needsDeleteConfirm">
                        <button class="btn btn-danger btn-flat pull-right" @click="deleteAction" :disabled="deleting">Are you sure?</button>
                    </div>
                    <div v-else>
                        <button class="btn btn-success btn-flat pull-right" @click="edit">Edit</button>
                        <button class="btn btn-danger btn-flat pull-right" @click="confirm">Delete</button>
                    </div>
                </li>
              </ul>
            </div>
          </div>

        <router-link :to="{name: 'companies'}"><i class="fa fa-arrow-left"></i></router-link>
        
        <modal v-on:close="closeModal" v-if="modalVisible" :save="false">
            <template v-slot:header>Create New Company</template>
            <template v-slot> 
                <create-form edit type='company' :fields="editCompany" v-on:close="closeModal"></create-form>
            </template>
        </modal>

    </div>
</template>

<script>
    import http from '../services/http'
    import {
        SET_COMPANY,
        DELETE_COMPANY,
        COMPANY
    } from '../store/constants'
    import pathMixin from '../mixins/paths'
    import modalMixin from '../mixins/modal'
    import {mapGetters} from 'vuex'
    export default {
        name:'company',
        data() {
            return {
                editCompany: [],
                needsDeleteConfirm: false,
                deleting: false
            }
        },
        props:['id'],
        mixins:[pathMixin, modalMixin],
        computed: {
            ...mapGetters([COMPANY]),
            company(){
                return this[COMPANY](this.id)
            }
        },
        watch: {
            $route:'get'
        },
        methods: {
            get(){
                 http.getCompany(this.id).then(({data}) => {
                    this.$store.commit(SET_COMPANY, data)
                }, error => {
                    console.log(error)
                })
            },
            goToCompaniesList(){
                this.$router.push({'name': 'companies'})
            },
            edit(){
                this.editCompany = Object.assign({}, this.company)
                this.showModal()
            },
            confirm(){
                this.needsDeleteConfirm = true
            },
            deleteAction(){
                this.deleting = true
                http.deleteCompany(this.id).then(response => {
                    let id = this.id
                    this.$store.commit(DELETE_COMPANY, {id});
                    this.deleting = false
                    this.needsDeleteConfirm = false
                    this.$router.push({name:'companies'})
                });
            }
        },
        created(){
            this.get()
        }

}
</script>

<style>
.widget-user-image img {
    max-height: 65px;
}
.actions {
    padding-left:20px;
}
</style>
