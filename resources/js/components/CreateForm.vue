<template>
    <form class="form-horizontal" v-on:submit="submit">
        <div class="box-body">
            <div v-if="isCompanyDetail" class="form-group" v-bind:class="{'has-error': errorKeys.includes('name')}">
                <label for="cName" class="col-sm-2 control-label">Name</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="cName" placeholder="Name" v-model="inputs['name']" minlength="4" required>
                </div>
            </div>
            <div v-if="isEmployeeDetail" class="form-group" v-bind:class="{'has-error': errorKeys.includes('first_name')}">
                <label for="eFirstName" class="col-sm-2 control-label">Name</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="eFirstName" placeholder="First Name" v-model="inputs['first_name']" minlength="2" required>
                </div>
            </div>
            <div v-if="isEmployeeDetail" class="form-group" v-bind:class="{'has-error': errorKeys.includes('last_name')}">
                <label for="eLastName" class="col-sm-2 control-label">Name</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="eLastName" placeholder="Last Name" v-model="inputs['last_name']" minlength="2" required>
                </div>
            </div>
            
            <div class="form-group" v-bind:class="{'has-error': errorKeys.includes('email')}">
            <label for="cEmail" class="col-sm-2 control-label">Email</label>

                <div class="col-sm-10">
                    <input type="email" class="form-control" id="cEmail" placeholder="Email" v-model="inputs['email']">
                </div>
            </div>
            <div v-if="isEmployeeDetail" class="form-group" v-bind:class="{'has-error': errorKeys.includes('phone')}">
                <label for="ePhone" class="col-sm-2 control-label" >Phone</label>

                <div class="col-sm-10">
                    <input type="tel" class="form-control" id="ePhone" placeholder="Phone" v-model="inputs['phone']">
                </div>
            </div>
            <template v-if="isCompanyDetail">
                <div  class="form-group" v-bind:class="{'has-error': errorKeys.includes('website')}">
                    <label for="cWebsite" class="col-sm-2 control-label" >Website</label>

                    <div class="col-sm-10">
                        <input type="url" class="form-control" id="cWebsite" placeholder="Website" v-model="inputs['website']">
                    </div>
                </div>
                <div class="form-group" v-bind:class="{'has-error': errorKeys.includes('logo')}">
                    <label for="cLogo" class="col-sm-2 control-label">Logo</label>

                    <div class="col-sm-10">
                        <input type="file"  class="form-control" id="cLogo" placeholder="Logo" accept="image/x-png,image/gif,image/jpeg" v-on:change="readFile" ref="uploadFile">
                    </div>
                </div>
                <div class="form-group preview-image text-center" v-if="url">
                    <img  :src="url" />
                </div>
            </template>
        </div>
        <div class="box-footer" v-if="hasErrors">
            <error-report :errors="errors" @close="clearErrors"></error-report>
        </div>
        <div class="box-footer" v-if="successMessage">
            <success-report :message="successMessage" @close="cancel" autoclose></success-report>
        </div>
        <div class="box-footer">
            <button type="button" class="btn btn-default pull-left" @click="cancel">Cancel</button>
            <button type="submit" class="btn btn-info pull-right" :disabled="showLoader">Save</button>
            <i class="fa fa-refresh fa-spin pull-right loading" v-show="showLoader"></i>
        </div>
        
    </form>
</template>
<script>
import http from '../services/http'
import {SET_COMPANY, BASE_IMG_PATH, SET_EMPLOYEE} from '../store/constants'
export default {
    name: 'createForm',
    data(){
        return {
            inputs:{},
            url: '',
            errors:{},
            showLoader: false,
            successMessage:''
        }
    },
    created(){
        if(!this.edit) {
            this.fields.forEach(el => {
                this.$set(this.inputs, el, '')
            })
        } else {
            this.inputs = Object.assign({}, this.fields)
            this.url = BASE_IMG_PATH + this.inputs.logo
        }
    },
    props:{
        fields: Array|Object, 
        type: String, 
        edit: Boolean,
        companyId: Number
    },
    computed: {
        errorKeys(){
            return this.errors.errors ? Object.keys(this.errors.errors) : []
        },
        isCompanyDetail() {
            return this.type === 'company'
        },
        isEmployeeDetail() {
            return this.type !== 'company'
        },

        hasErrors(){
            return this.errors.errors;
        }
    },
    methods: {
        submit(event){
            event.preventDefault();
            

            if (this.isCompanyDetail) {
                if (!this.inputs.name.trim().length) {
                    return false;
                }
                
                this.handleCompanyDetails()
            } else {
                this.handleEmployeeDetails()
            }
        },
        handleEmployeeDetails(){
            this.loading();
            let promise = null;
            if(this.edit) {
                let onlyChanged = this.inputs;
                
                if (onlyChanged.first_name === this.fields.first_name) {
                    delete onlyChanged.email
                }

                if (onlyChanged.last_name === this.fields.last_name) {
                    delete onlyChanged.logo
                }
                
                promise = http.updateEmployee(this.companyId, this.fields.id, onlyChanged)
            } else {
                promise = http.createEmployee(this.companyId, this.inputs)
                
            }

            promise.then(({data}) => {
                this.stopLoading()
                    this.$store.commit(SET_EMPLOYEE, this.companyId, {...data})
              
                    this.showSuccess(this.type.toUpperCase() + ' has been saved succesfully!');
                }, ({response}) => {
                    this.stopLoading()
                    this.errors = response.data
            })
        },
        handleCompanyDetails(){
            let promise = null;
            if(this.edit) {
                let onlyChanged = this.inputs;
                if (onlyChanged.email === this.fields.email) {
                    delete onlyChanged.email
                }
                if (onlyChanged.logo === this.fields.logo) {
                    delete onlyChanged.logo
                }
                promise = http.updateCompany(this.fields.id, this.createFormObj(onlyChanged))
            } else {
                promise = http.createCompany(this.createFormObj(this.inputs))
                
            }

            promise.then(({data}) => {
                this.stopLoading()
                    this.$store.commit(SET_COMPANY, {...data})
              
                    this.showSuccess(this.type.toUpperCase() + ' has been saved succesfully!');
                }, ({response}) => {
                    this.stopLoading()
                    this.errors = response.data
            })
        },
        showSuccess(msg = ''){
            this.successMessage = msg; 
        },
        loading(){
            this.showLoader = true
            this.clearErrors()
        },
        clearErrors(){
            this.errors = {}
        },
        stopLoading(){
            this.showLoader = false
        },
        createFormObj(obj){
            let formData = new FormData()
            for(let key in obj){
                if(obj[key] && Array.isArray(obj[key])){
                    for (var i = 0; i < obj[key].length; i++) {
                        formData.append(key+'[]', obj[key][i])
                    }
                } else formData.append(key, obj[key]);
            }
            return formData;
        },
        readFile(event){
            let file = this.$refs['uploadFile'].files[0]
            if (file) {
                this.url = URL.createObjectURL(file)
            } else {
                this.url = '';
            } 
            this.inputs['logo'] = file
        },
        cancel(){
            this.clearErrors()
            this.showSuccess('')
            this.$emit('close') 
        }
    }
}
</script>

<style>
    .preview-image img{
        max-width: 100%;
        max-height: 200px;
    }

    .loading {
        font-size: 25px;
        padding: 3px 10px;
    }
</style>
