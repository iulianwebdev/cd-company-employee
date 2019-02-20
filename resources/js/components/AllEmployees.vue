<template>
    <div class="all-employees">
        <router-link :to="{name: 'dashboard'}"><i class="fa fa-arrow-left"></i></router-link>
        <employees v-bind:companyId="'all'"></employees>
        
    </div>
</template>
<script>
import Employees from './Employees';

export default {
    name:'all-employees',
    components:{
        [Employees.name]: Employees
    }
}
</script>

