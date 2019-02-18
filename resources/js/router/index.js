import Vue from 'vue'
import VueRouter from 'vue-router'
import merge from 'lodash/merge'

Vue.use(VueRouter)

export const defaultRouterOptions = (opts = {}) => merge({
  // mode: 'history',
  routes: []
}, opts)

export default defaultRouterOptions
