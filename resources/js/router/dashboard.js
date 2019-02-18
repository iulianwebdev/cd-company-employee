import DashboardWrapperComponent from '../components/DashboardWrapperComponent'
import DashboardComponent from '../components/DashboardComponent'
import CompaniesComponent from '../components/CompaniesComponent'
import CompanyEmployeesComponent from '../components/CompanyEmployeesComponent'
import CompanyComponent from '../components/CompanyComponent'
import EmployeesComponent from '../components/EmployeesComponent'

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
        name: 'employees',
        component: EmployeesComponent,
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
