import Vue from 'vue'

import merge from 'lodash/merge'
import ModalComponent from '../components/Modal'
import CreateFormComponent from '../components/CreateForm'
import SuccessFlashComponent from '../components/SuccessFlash'
import ErrorReportComponent from '../components/ErrorReport'
import PaginatorComponent from '../components/Paginator'
import SortByComponent from '../components/SortBy.vue'
require('../helpers')

// TODO: build function to dynamically import modules
Vue.component(SortByComponent.name, SortByComponent)
Vue.component(ModalComponent.name, ModalComponent)
Vue.component(CreateFormComponent.name, CreateFormComponent)
Vue.component(SuccessFlashComponent.name, SuccessFlashComponent)
Vue.component(ErrorReportComponent.name, ErrorReportComponent)
Vue.component(PaginatorComponent.name, PaginatorComponent)

window.Vue = Vue
export const defaultAppOptions = (opts = {}) => merge({
  el: '#app',
  data: {}
}, opts)

export default defaultAppOptions
