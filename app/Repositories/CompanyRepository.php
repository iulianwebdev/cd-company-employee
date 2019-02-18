<?php

namespace App\Repositories;

use App\Company;
use App\Contracts\CompanyStore;
use App\Exceptions\ModelRelationNotEmptyException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Company repository.
 */
class CompanyRepository extends BaseRepository implements CompanyStore
{
    public function __construct(Company $companyModel)
    {
        $this->model = $companyModel;
    }

    public function delete(int $id)
    {
        $existing = $this->model->findOrFail($id);

        if ($existing->employees()->count() > 0) {
            throw new ModelRelationNotEmptyException('Can not delete this company.');
        }

        if (!parent::delete($id)) {
            throw new ModelNotFoundException('Unkown error on deletion.');
        }

        return $existing;
    }

    /**
     * Function to abstrat (Eloquent)Company model method.
     *
     * @TODO: a bit expensive, think of a different implementation.
     *
     * @param string $name
     */
    public function getLogoName(string $name, int $id): string
    {
        $existingCompany = $this->findOrFail($id);
        $existingCompany->name = $name;

        return $existingCompany->logo_name;
    }

    /**
     * Eager loading abstract implementation.
     *
     * @param array|string $relations
     *
     * @return Model
     */
    public function getEmployees(int $id)
    {
        return $this->model
                ->with('employees')
                ->find($id)
                ->employees()->get();
    }
}
