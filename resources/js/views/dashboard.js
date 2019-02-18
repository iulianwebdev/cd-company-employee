import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'

import routes from '../router/dashboard'
import defaultStoreOptions from '../store'
import defaultRouterOptions from '../router'
import defaultAppOptions from '../views'

export const store = new Vuex.Store(defaultStoreOptions)
export const router = new VueRouter(defaultRouterOptions({ routes,
  linkActiveClass: 'active', // active class for non-exact links.
  linkExactActiveClass: 'active' // active class for *exact* links
}))

export const app = window.app = new Vue(defaultAppOptions({
  router,
  store
}))

export default app
