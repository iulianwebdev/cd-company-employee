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
    public function index_returns_all_companies()
    {
        $fakeCompanies = factory(Company::class, 5)->states('with_id')->make();

        $this->mock
            ->shouldReceive('all')
            ->once()
            ->andReturn($fakeCompanies);

        $response = $this->json('get', 'companies');
        
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name','email','logo','website'],
            ],
        ], $response->json());

        $response->assertStatus(200);
    }
}
