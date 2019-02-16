<?php

namespace App\Providers;

use App\Contracts\EmployeeStore;
use App\Repositories\EmployeeRepository;
use Illuminate\Support\ServiceProvider;

class EmployeeRepositoryServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
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

    /**
    * Get the services provided by the provider.
    *
    * @return array
    */
    public function provides()
    {
      return [EmployeeRepository::class];
    }
}
