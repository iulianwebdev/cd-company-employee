import Vue from 'vue'

import merge from 'lodash/merge'
import Modal from '../components/Modal'
import CreateForm from '../components/CreateForm'
import SuccessFlash from '../components/SuccessFlash'
import ErrorReport from '../components/ErrorReport'

Vue.component(Modal.name, Modal)
Vue.component(CreateForm.name, CreateForm)
Vue.component(SuccessFlash.name, SuccessFlash)
Vue.component(ErrorReport.name, ErrorReport)

window.Vue = Vue
export const defaultAppOptions = (opts = {}) => merge({
  el: '#app',
  data: {}
}, opts)

export default defaultAppOptions
