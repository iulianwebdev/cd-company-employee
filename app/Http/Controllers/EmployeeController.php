<?php

namespace App\Http\Controllers;

use App\Company;
use App\Contracts\EmployeeStore;
use App\Contracts\CompanyStore;
use App\Employee;
use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Resources\EmployeeCollection as EmployeesResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    private $employeeStore;

    private $companyStore;

    public function __construct(EmployeeStore $eStore, CompanyStore $cStore)
    {
        $this->employeeStore = $eStore;
        $this->companyStore = $cStore;
    }

    /**
     * Display a listing of the Employees resource.
     *
     * @param \App\Company $company
     *
     * @return \Illuminate\Http\Response
     */
    public function index($companyOrAll, int $perPage = 10, string $order = 'desc', string $sortBy = 'id')
    {
        $where = null;
        if ($companyOrAll !== 'all') {
            $company = $this->companyStore->findOrFail($companyOrAll);
            $where = ['company_id', $company->id];
        }

        return new EmployeesResource(
            $this->employeeStore
                ->getPaginatedEmployees($sortBy, $order, $perPage, $where)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Company             $company
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request, Company $company)
    {
        if (!$request->has('first_name') || !$request->has('last_name')) {
            throw BadRequestHttpException('Bad request call');
        }

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company_id' => $company->id,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        $newEmployee = $this->employeeStore->create($data);

        return new EmployeeResource($newEmployee);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Company  $company
     * @param \App\Employee $employee
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, Employee $employee)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Company             $company
     * @param \App\Employee            $employee
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company, Employee $employee)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Company  $company
     * @param \App\Employee $employee
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, Employee $employee)
    {
        if ($company != $employee->company) {
            throw new ModelNotFoundException();
        }
        $deleted = $this->employeeStore->delete($employee->id);

        return response(Response::HTTP_OK);
    }
}
