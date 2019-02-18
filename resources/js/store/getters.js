import {
  COMPANIES,
  COMPANY,
  COMPANY_EMPLOYEES,
  EMPLOYEES,
  EMPLOYEE
} from './constants'

export const getters = {
  [COMPANIES] (state) {
    return state.companies
  },
  [COMPANY]: (state) => (id) => {
    return state.companies.find(_ => _.id === +id)
  },
  [COMPANY_EMPLOYEES]: (state) => (id) => {
    return state.employees[id] || []
  },
  [EMPLOYEES] (state) {
    return state.employees
  },
  [EMPLOYEE]: (state) => (id) => {
    return state.employees.find(_ => _.id === +id)
  }
}

export default getters
