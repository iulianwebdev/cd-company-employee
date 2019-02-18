<?php

namespace App\Providers;

use App\Contracts\CompanyStore;
use App\Contracts\EmployeeStore;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CompanyStore::class,
            CompanyRepository::class
        );

        $this->app->bind(
            EmployeeStore::class,
            EmployeeRepository::class
        );
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
