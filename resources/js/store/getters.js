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
  [COMPANY_EMPLOYEES]: (state) => (companyId) => {
    return state.employees[companyId] || []
  },
  [EMPLOYEES]: (state) => (companyId) => {
    if (!state.employees[companyId]) {
      return []
    }
    return state.employees[companyId]
  },
  [EMPLOYEE]: (state) => (companyId, id) => {
    if (!state.employees[companyId]) {
      return []
    }
    return state.employees.find(_ => _.id === +id)
  }
}

export default getters
