<template>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" v-on:click="close" :disabled="disableClose" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        {{message}}
        <span v-if="autoclose" class="small"><br/>Modal will autoclose</span>
    </div>
</template>

<script>
import { FLASH_SUCCESS_TIME } from '../store/constants'
export default {
    data(){
        return {
            disableClose: false
        }
    },
    name:'success-report',
    props:{
        message: String, 
        autoclose: Boolean
        },
    methods: {
        close(){
            this.disableClose = true
            setTimeout(() => {
                this.$emit('close')
            }, FLASH_SUCCESS_TIME)
        }
    },
    mounted(){
        if (this.autoclose == true) {

            this.disableClose = true
            setTimeout(() => {
                this.close()
            }, FLASH_SUCCESS_TIME)
        }
    }
}
</script>

