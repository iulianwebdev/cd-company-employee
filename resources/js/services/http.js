import axios from 'axios'

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
 * Update enmployee of a company
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

export const getEmployees = (companyId, params = {}) => axios.get(
  `${BASE}/${companyId}/employee`,
  {
    params
  }
)

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
  getAllCompanies,
  createCompany,
  updateCompany,
  deleteCompany,
  getEmployees,
  createEmployee,
  updateEmployee
}
