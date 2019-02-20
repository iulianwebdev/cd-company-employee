<template>
    <div class="row">
        <div class="col-sm-5" v-if="pagerData">
            <div class="dataTables_info" role="status" aria-live="polite">Showing {{pagerData.from}} to {{pagerData.to}} of {{pagerData.total}} entries
            </div>
            <div class="form-group">
                  <label>Select per page</label>
                  <select v-model="perPage" class="form-control">
                    <option 
                    v-for="(option, index) in perPageData" v-bind:key="index" 
                    v-bind:value="index">
                    {{ option }}</option>
                  </select>
                </div>
        </div>
        <div class="col-sm-7">
            <div class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination">
                    <li class="paginate_button previous" :class="{'disabled': !showPrev}"><a href="#" v-on:click.prevent="goToPrevious(currentPage)">Previous</a></li>

                    <template v-for="(page, key) in pages" >
                        <li class="paginate_button" 
                            v-bind:class="{'active': currentPage === page}" 
                            v-bind:key="key">

                        <a v-on:click="updateCurrentPage(page)" v-if="page !== '...'">{{page}}</a>
                        <a v-else>{{page}}</a>
                        </li>
                
                    </template>

                    <li class="paginate_button next" :class="{'disabled': !showNext}"><a href="#" v-on:click.prevent="goToNext(currentPage)">Next</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script lang="js">

import paginator from "../helpers/paginate";
export default {
    name: 'paginator-vue',
    data () {
        return {
            perPage: 2,
            perPageData: [2,5,10,15,25,50],
            currentPage: 1
        }
    },
    props:['pagerData'],
    computed: {
        pages(){
            let pages = paginator(this.currentPage, this.pagerData.last_page);
            return pages;
        },
        showPrev() {
            return this.currentPage > 1
        },
        showNext() {
            return this.currentPage < this.pages.last()
        }
    },
    watch: {
        perPage : 'paginate'
    },
    methods: {
        paginate(){
            this.$emit('paginate', {
                current_page: this.currentPage,
                per_page: this.perPageData[this.perPage]
                })
        },
        updateCurrentPage(newValue){
            if(newValue !== this.currentPage && !isNaN(newValue)){
                this.currentPage = newValue
                this.paginate()
            }
        },
        goToNext(num){
            if (this.showNext){
                this.updateCurrentPage(num + 1)
            }
        },
        goToPrevious(num){
            if (this.showPrev) {
                this.updateCurrentPage(num - 1)
            }
        }
        
    }
    
}
</script>

<style lang="scss">
    .pagination > li a{
        cursor: pointer;
    }
</style>


