import DashboardWrapperComponent from '../components/DashboardWrapper'
import DashboardComponent from '../components/Dashboard'
import CompaniesComponent from '../components/Companies'
import CompanyEmployeesComponent from '../components/CompanyEmployees'
import CompanyComponent from '../components/Company'
import AllEmployeesComponent from '../components/AllEmployees'

export const routes = [
  {
    path: '/',
    name: 'home',
    component: DashboardWrapperComponent,
    children: [
      {
        path: '/',
        name: 'dashboard',
        component: DashboardComponent
      },
      {
        path: '/companies',
        name: 'companies',
        component: CompaniesComponent,
        props: false
      },
      {
        path: '/companies/:id(\\d+)',
        name: 'company',
        component: CompanyComponent,
        props: true
      },
      {
        path: '/companies/:companyId(\\d+)/employee',
        name: 'company-employees',
        component: CompanyEmployeesComponent,
        props: true
      },
      {
        path: '/employees',
        name: 'all-employees',
        component: AllEmployeesComponent,
        props: false
      }
      // {
      //   path: 'company/:companyId(\\d+)'
      // },
      // {
      //   path: 'company/:companyId(\\d+)/csv-upload',
      //   meta: { useCSVUpload: true }
      // },
      // {
      //   path: 'company/:companyId(\\d+)/branch/:branchId(\\d+)'
      // },
      // {
      //   path: 'company/:companyId(\\d+)/branch/:branchId(\\d+)/csv-upload',
      //   meta: { useCSVUpload: true }
      // }
    ]
  }
]

export default routes
