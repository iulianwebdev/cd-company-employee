<?php

// @phpcs:disable PSR1.Methods.CamelCapsMethodName

namespace Tests\Unit;

use App\Company;
use App\Contracts\CompanyStore;
use App\Employee;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Mockery;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    private $repository;

    public function setUp()
    {
        parent::setUp();
        $this->seed();

        $this->mock = Mockery::mock(CompanyStore::class);
    }

    private function withMock()
    {
        $this->app->instance(CompanyStore::class, $this->mock);
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function endpoint_not_accessible_for_guests()
    {
        $this->withMock();
        // one endpoint will do for now
        $response = $this->json('get', 'companies');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test READ endpoint for Companies
     */
    public function index_returns_all_companies()
    {
        $this->withMock();
        $this->logIn();

        $fakeCompanies = factory(Company::class, 5)->states('with_id')->make();

        $this->mock
            ->shouldReceive('all')
            ->once()
            ->andReturn($fakeCompanies);

        $response = $this->json('GET', 'companies');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'email', 'logo', 'website'],
            ],
        ], $response->json());
    }

    /** @test */
    public function show_returns_one_company()
    {
        $this->withMock();
        $this->logIn();

        $fakeCompany = factory(Company::class)->states('with_id')->make();

        $this->mock
            ->shouldReceive('find')
            ->with($fakeCompany->id)
            ->once()
            ->andReturn($fakeCompany);

        $response = $this->json('GET', "companies/{$fakeCompany->id}");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'email', 'logo', 'website'],
            ]);
    }

    /**
     * @test CREATE
     */
    public function store_method_creates_new_company_with_logo()
    {
        $this->withMock();
        $this->withoutMiddleware();
        $this->logIn();

        Storage::fake('public');

        $newCompany = factory(Company::class)->states('with_id')->make([
            'logo' => UploadedFile::fake()->image('logo.png', 100, 100),
        ]);

        $nameSlug = str_slug($newCompany->name);

        $this->mock
            ->shouldReceive('create')
            ->once()
            ->andReturn($newCompany);
        $logo = "{$nameSlug}-{$newCompany->id}.png";

        $this->mock
            ->shouldReceive('update')
            ->with($newCompany->id, ['logo' => $logo])
            ->andReturn(true);

        $response = $this->json('POST', 'companies/', $newCompany->toArray());

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $response->assertJsonStructure([
            'data' => ['id', 'name', 'email', 'logo', 'website'],
        ]);

        $json = $response->json();

        Storage::disk('public')->assertExists("images/{$json['data']['logo']}");
    }

    /**
     * @param $attrs
     *
     * @testWith [{"name":"","email":"ok@email.com"}]
     *           [{"name":"Name Ok","email":"wrongemail.com"}]
     *           [{"name":"Name Ok","email":"ok@email.com","website":"wrong-url"}]
     *
     * @test CREATE >> fails with message
     */
    public function test_bad_format_attributes_receive_validation_error_msg(array $attrs)
    {
        $this->withMock();
        $this->logIn();

        $response = $this->json('POST', 'companies', $attrs);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function test_update_returns_ok_status()
    {
        // $this->withMock();
        $this->logIn();

        $existingCompany = factory(Company::class)->create();

        Storage::fake('public');

        $newCompany = factory(Company::class)->make([
            'logo' => UploadedFile::fake()->image('logo.png', 100, 100),
        ]);

        $employee = factory(Employee::class)->make();

        $response = $this->json('PUT', "/companies/{$existingCompany->id}", $newCompany->toArray());

        $response->assertJsonStructure([
            'data' => ['id', 'name', 'email', 'logo', 'website'],
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function test_destroy_method()
    {
        $this->withMock();
        $this->logIn();

        Storage::fake('public');

        $company = factory(Company::class)->create([
            'logo' => 'test.txt',
        ]);

        Storage::disk('public')->put("images/{$company->logo}", 'Sample text');

        $this->mock
            ->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn($company);

        $response = $this->json('DELETE', '/companies/1');
        $response->assertStatus(Response::HTTP_OK);
        Storage::disk('public')->assertMissing("images/{$company->logo}");
    }

    /**
     * @test
     *
     * @throws ModelRelationNotEmptyException
     */
    public function test_that_company_whith_employees_cant_be_deleted()
    {
        $this->logIn();

        $company = factory(Company::class)->create([]);
        $employees = factory(Employee::class, 10)->make();
        $company->employees()->saveMany($employees);

        $response = $this->json('DELETE', "/companies/{$company->id}");

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    private function logIn($user = null)
    {
        $user = $user ?? factory(User::class)->create();

        $this->be($user);
    }
}
