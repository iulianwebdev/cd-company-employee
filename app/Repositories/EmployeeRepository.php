<?php

namespace App\Repositories;

use App\Employee;
use App\Contracts\EmployeeStore;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Company repository.
 */
class EmployeeRepository extends BaseRepository implements EmployeeStore
{
    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    public function getPaginatedEmployees(string $sortBy, string $order, int $num, $where = null)
    {
        $builder = $this->model->query();
        if ($where) {
            $builder->where([$where]);
        }
        // dd($builder);

        return $builder->orderBy($sortBy, $order)
                ->paginate($num);
    }

    /**
     * @param string $email
     *
     * @throws ModelNotFoundException
     *
     * @return Employee
     */
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->firstOrFail();
    }
}
