<template>
    <div class="col-xs-12">
        <div class="col-md-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 title="Loaded">{{employeesCount}}</h3>

              <p>Employees</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <router-link :to="{name:'all-employees'}" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <div class="col-md-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 title="Loaded">{{companiesCount}}</h3>

              <p>Companies</p>
            </div>
            <div class="icon">
              <i class="fa fa-building-o"></i>
            </div>
            <router-link :to="{name:'companies'}" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import {COMPANIES, EMPLOYEES} from '../store/constants'
import http from '../services/http';

    export default {
        name:'dashboard',
        data(){
          return {
            companiesCount: 0,
            employeesCount: 0,
          }
        },
        mounted() {
          http.getCounts().then(({data}) => {
            this.companiesCount = data.company_counts;
            this.employeesCount = data.employee_counts;
          })
        }
    }
</script>
