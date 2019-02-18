<template>
    <div>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" @click="$emit('close')" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i>{{errors.message}}</h4>
            <ul v-if="errorsToDisplay.length">
                <li v-for="errorText in errorsToDisplay">
                    {{errorText}}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name:'error-report',
    props:['errors'],
    computed: {
        errorsToDisplay(){
            if(this.errors.errors){
                return Object.values(this.errors.errors).map(error => error[0]);
            }
            return [];
        }
    }
}
</script>

