<?php

namespace App\Repositories;

use App\Company;
use App\Contracts\CompanyStore;
use App\Repositories\BaseRepository;

/**
 * Company repository
 */

class CompanyRepository extends BaseRepository implements CompanyStore
{

    function __construct(Company $companyModel)
    {
        $this->model = $companyModel;
    }
}
