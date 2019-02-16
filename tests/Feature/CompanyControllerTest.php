<?php

namespace Tests\Unit;

use App\Company;
use App\Contracts\CompanyStore;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \Mockery;

class CompanyControllerTest extends TestCase
{

    use RefreshDatabase;

    private $repository;

    public function setUp() 
    {
        parent::setUp();
        $this->seed();

        $class = CompanyStore::class;

        $this->mock = Mockery::mock($class);

        $this->app->instance($class, $this->mock);
 
        return $this->mock;
    }

    public function tearDown() 
    {
        Mockery::close();
        parent::tearDown();
    }


    /**
     * @test READ endpoint for Companies 
     *
     * @return void
     */
    public function canShowAll()
    {
        
        $fakeCompanies = factory(Company::class, 10)->make();

        $this->mock
            ->shouldReceive('all')
            ->once()
            ->andReturn($fakeCompanies);

        $response = $this->call('get', 'companies');

        $response->assertStatus(200);
    }
}
