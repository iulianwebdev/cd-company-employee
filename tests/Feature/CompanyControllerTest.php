<?php

namespace Tests\Unit;

use App\Company;
use App\Contracts\CompanyStore;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{

    use DatabaseMigrations;

    private $repository;

    public function setUp() 
    {
        parent::setUp();
        $this->seed();

        $this->repository = resolve(CompanyStore::class);


    }


    /**
     * test we can create a company via the repository.
     *
     * @return void
     */
    public function test_index_returns_all_companies()
    {
        $fields = [
            'name' => 'Test Company',
            'email' => 'test@company.com',
        ];
        
        $company = $this->repository->create($fields);

        $testCompany = Company::where('email', $fields['email'])->first();
        $this->assertEquals($testCompany->id, $company->id);
    }
}
