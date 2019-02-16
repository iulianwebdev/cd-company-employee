<?php

namespace App\Repositories;

use App\Employee;
use App\Contracts\EmployeeStore;
use App\Repositories\BaseRepository;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Company repository
 */

class EmployeeRepository extends BaseRepository implements EmployeeStore
{

    function __construct(Employee $model)
    {
        $this->model = $model;
    }

    /**
     * 
     * @param  string $email
     * @throws ModelNotFoundException
     * @return Employee
     */
    public function findByEmail(string $email) 
    {
        return $this->model->where('email', $email)->firstOrFail();
    }
}
