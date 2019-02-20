import * as constants from './constants'
import Vue from 'vue'

export const mutations = {
  [constants.SET_COMPANIES] (state, payload = {}) {
    state.companies.splice(0)
    let { data } = payload
    state.companies.push(...data)
  },
  [constants.SET_COMPANY] (state, payload = {}) {
    let { data } = payload
    let idx = state.companies.findIndex(x => x.id === data.id)
    if (idx > -1) {
      Vue.set(state.companies, idx, data)
    } else {
      state.companies.push(data)
    }
  },
  [constants.DELETE_COMPANY] (state, { id }) {
    let idx = state.companies.findIndex(x => x.id === id)
    if (idx !== -1) {
      state.companies.splice(idx, 1)
    }
  },
  [constants.SET_EMPLOYEES] (state, payload = {}) {
    let { companyId, data } = payload
    console.log('inside mutation', companyId, state.employees)
    if (state.employees[companyId]) {
      state.employees[companyId].splice(0)
    } else {
      Vue.set(state.employees, companyId, [])
    }
    state.employees[companyId].push(...data)
  },
  [constants.SET_EMPLOYEE] (state, {companyId, data}) {

    if (!state.employees[companyId]) {
      Vue.set(state.employees, companyId, [])
    }
    
    state.employees.push(data.data)
    
  }
}

export default mutations
