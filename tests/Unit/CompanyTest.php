<?php

namespace Tests\Unit;

use App\User;
use App\Company;
use App\Contracts\CompanyStore;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class CompanyTest extends TestCase
{

    use RefreshDatabase;

    private $repository;

    public function setUp() 
    {
        parent::setUp();
        $this->seed();

        $this->repository = resolve(CompanyStore::class);
    }

    /**
     * @test it CREATEs company.
     *
     * @return void
     */
    public function canCreate()
    {
        $fakeCompany = factory(Company::class)->make();
        $company = $this->repository->create($fakeCompany->toArray());

        $this->assertInstanceOf(Company::class, $company);
        $this->assertEquals($fakeCompany->name, $company->name);
        $this->assertEquals($fakeCompany->email, $company->email);
    }

    /**
     * @test it can READ all
     * 
     * @return void
     */
    public function canShowAll() 
    {
        $companyCollection = factory(Company::class, 10)->create();
        $companyCollectionDouble = $this->repository->all();

        $this->assertInstanceOf(Collection::class, $companyCollectionDouble);
        $this->assertEquals($companyCollectionDouble->count(), $companyCollection->count());

    }

    /**
     * @test it can READ one 
     * 
     * @return [type] [description]
     */
    public function canShowOneCompany() 
    {
        $company = factory(Company::class)->create();
        $companyDouble = $this->repository->find($company->id);

        $this->assertInstanceOf(Company::class, $companyDouble);
        $this->assertEquals($companyDouble->id, $company->id);
        $this->assertEquals($companyDouble->name, $company->name);
        $this->assertEquals($companyDouble->email, $company->email);
    }

    /**
     * @test it can UPDATE a Company
     * 
     * @return void
     */
    public function canUpdate() 
    {
        $company = factory(Company::class)->create();

        $newName = 'Test Updated Name';
        $companyUpdated = $this->repository->update($company->id, [
            'name' => $newName
        ]);
        $companyDouble =  $this->repository->find($company->id);
        
        $this->assertInstanceOf(Company::class, $companyDouble);
        $this->assertTrue($companyUpdated);
        $this->assertEquals($companyDouble->id, $company->id);
        $this->assertEquals($companyDouble->name, $newName);
        $this->assertEquals($companyDouble->email, $company->email);
    }

    /**
     * @test it can DELETE
     * 
     * @return void
     */
    public function canDeleteById() 
    {
        $companies = factory(Company::class, 10)->create();

        $companyToDelete = $companies->first();
        $deletedSuccesfully = $this->repository->delete($companyToDelete->id);

        $remainingCompanies = $this->repository->all();

        $this->assertTrue($deletedSuccesfully == 1);
        $this->assertLessThan($companies->count(), $remainingCompanies->count());

        $this->assertEmpty($this->repository->find($companyToDelete->id));
    }

}
