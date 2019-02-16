<?php

namespace Tests\Unit;

use App\Contracts\EmployeeStore;
use App\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    private $repository;

    public function setUp() 
    {
        parent::setUp();
        $this->seed();

        $this->repository = resolve(EmployeeStore::class);
    }


    /**
     * @test it can CREATE Employee.
     *
     * @return void
     */
    public function canCreate()
    {
        $fakeEmployee = factory(Employee::class)->make();
        $employee = $this->repository->create($fakeEmployee->toArray());

        $this->assertInstanceOf(Employee::class, $employee);
        $this->assertEquals($fakeEmployee->firstName, $employee->firstName);
        $this->assertEquals($fakeEmployee->lastName, $employee->lastName);
        $this->assertEquals($fakeEmployee->email, $employee->email);
        $this->assertEquals($fakeEmployee->phone, $employee->phone);
    }

    /** 
     * @test
     *
     * @return void
     */
    public function canShowAll() 
    {
        $employeeCollection = factory(Employee::class, 10)->create();
        $employeeCollectionDouble = $this->repository->all();


        $this->assertInstanceOf(Collection::class, $employeeCollectionDouble);
        $this->assertEquals($employeeCollectionDouble->count(), $employeeCollection->count());

    }

    /**
     * @test it can READ from repository
     *
     * @return void
     */
    public function canShowOneEmployee() 
    {
        $employee = factory(Employee::class)->create();
        $employeeDouble = $this->repository->find($employee->id);

        $this->assertInstanceOf(Employee::class, $employeeDouble);
        $this->assertEquals($employeeDouble->id, $employee->id);
        $this->assertEquals($employeeDouble->name, $employee->name);
        $this->assertEquals($employeeDouble->email, $employee->email);
    }

    /**
     * @test we can UPDATE Employee
     *
     * @return void
     */
    public function canUpdate() 
    {
        $employee = factory(Employee::class)->create();
        $dataToUpdate = [
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
        ];

        $employeeUpdated = $this->repository->update($employee->id, $dataToUpdate);
        $employeeDouble =  $this->repository->find($employee->id);
        
        $this->assertInstanceOf(Employee::class, $employeeDouble);
        $this->assertTrue($employeeUpdated);
        $this->assertEquals($employeeDouble->id, $employee->id);
        $this->assertEquals($employeeDouble->email, $dataToUpdate['email']);
        $this->assertEquals($employeeDouble->first_name, $dataToUpdate['first_name']);
        $this->assertEquals($employeeDouble->last_name, $dataToUpdate['last_name']);
        $this->assertEquals($employeeDouble->phone, $dataToUpdate['phone']);
        $this->assertEquals($employeeDouble->company_id, $employee->company_id);
    }

    /**
     * @test it can DELETE Employee
     *
     * @return void
     */
    public function canDeleteById() 
    {
        $companies = factory(Employee::class, 10)->create();

        $employeeToDelete = $companies->first();
        $deletedSuccesfully = $this->repository->delete($employeeToDelete->id);

        $remainingEmployees = $this->repository->all();

        $this->assertTrue($deletedSuccesfully == 1);
        $this->assertLessThan($companies->count(), $remainingEmployees->count());
        $this->assertEmpty($this->repository->find($employeeToDelete->id));
    }
}
