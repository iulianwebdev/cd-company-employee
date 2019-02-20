import axios from 'axios'
import { PER_PAGE } from '../store/constants'

const BASE = '/companies'

/**
 * Get all companies
 *
 * @return {Promise}
 */
export const getAllCompanies = (params = {}) => axios.get(
  `${BASE}`,
  {
    params
  }
)

/**
 * Get company by id
 *
 * @return {Promise}
 *
 */
export const getCompany = (companyId, params = {}) => axios.get(
  `${BASE}/${companyId}`,
  {
    params
  }
)


/**
 * Get counters
 *
 * @return {Promise}
 *
 */
export const getCounts = (params = {}) => axios.get(
  `/counts`,
  {
    params
  }
)

/**
 * Delete company by id
 *
 * @return {Promise}
 *
 */
export const deleteCompany = (companyId, params = {}) => axios.post(
  `${BASE}/${companyId}`,
  appendVerb('DELETE', new FormData()),
  {
    headers: { 'Content-Type': 'multipart/form-data' }
  }
)

/**
 * Delete Employee by id
 *
 * @return {Promise}
 *
 */
export const deleteEmployee = (companyId, employeeId, params = {}) => axios.post(
  `${BASE}/${companyId}/employee/${employeeId}`,
  { _method: 'DELETE' }
)

/**
 * Create new company and return id and logo file
 *
 * @return {Promise}
 *
 */
export const createCompany = (params = {}) => axios.post(
  `${BASE}`,
  params,
  {
    headers: { 'Content-Type': 'multipart/form-data' }
  }
)

/**
 * Create new company and return id and logo file
 *
 * @return {Promise}
 *
 */
export const updateCompany = (companyId, params = {}) => axios.post(
  `${BASE}/${companyId}`,
  appendVerb('PUT', params),
  {
    headers: { 'Content-Type': 'multipart/form-data' }
  }
)

/**
 * Update employee of a company
 *
 * @return {Promise}
 *
 */
export const updateEmployee = (companyId, id, params = {}) => axios.post(
  `${BASE}/${companyId}/employee/${id}`,
  appendPutMethod(params)
)

/**
 * Create new employee
 *
 * @return {Promise}
 *
 */
export const createEmployee = (companyId, params = {}) => axios.post(
  `${BASE}/${companyId}/employee`,
  params
)

/**
 * Get al employees of a given Company
 *
 * @return {Promise}
 *
 */

export const getEmployees = (companyId, perPage = PER_PAGE, pageNum = '', sortBy = 'id', order = 'desc') => {
  if (pageNum) {
    pageNum = `?page=${pageNum}`
  }
  return axios.get(
  `${BASE}/${companyId}/employee/pages/${perPage}/${order}/${sortBy}${pageNum}`)
}

const appendVerb = (verb, formData) => {
  formData.append('_method', verb)
  return formData
}

const appendPutMethod = (data) => {
  data['_method'] = 'PUT'
  return data
}

export default {
  getCompany,
  getCounts,
  getAllCompanies,
  createCompany,
  updateCompany,
  deleteCompany,
  getEmployees,
  deleteEmployee,
  createEmployee,
  updateEmployee
}
