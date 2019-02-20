<template>
    <tr role="row" v-if="columns">
        <th tabindex="0" rowspan="1" colspan="1" aria-sort="ascending"         
            v-bind:class="{
                'sorting_asc': sortBy === name && order === orders.asc,
                'sorting_desc': sortBy === name && order === orders.desc,
                'sorting': sortBy !== name && !isExcluded(name)
                }" 
            v-for="(label, name)  in columns"
            v-bind:aria-label="label" 
            v-bind:key="name"
            v-on:click="sort(name)">
            {{label}}
        </th>
    </tr>
</template>
<script>
export default {
    name:'sort-by',
    data(){
        return {
            order: 'asc',
            sortBy: ''
        }
    },
    props:{
        columns:{
            type: Object,
            required: true,
            default: {}
        },
        disableOn:{
            type: Array,
            default: []
        }
    },
    created(){
        this.orders = {asc:'asc', desc:'desc'}

        let sortKeys = Object.keys(this.columns)

        if (sortKeys.length) {
            this.sortBy =  sortKeys[0]
        }
    },
    methods:{
        sort(name){
            if (this.isExcluded(name)) {
                return
            }
            this.sortBy = name;
            this.toggleOrder();

            let sort_by = this.sortBy 
            let order = this.order

            this.$emit('sort', {sort_by, order});
        },
        toggleOrder(){
            let newOrder = Object.values(this.orders).filter(val => val !== this.order)[0]
            this.order = newOrder
        },
        isExcluded(name) {
            return this.disableOn.indexOf(name) !== -1
        }
    }

}
</script>

