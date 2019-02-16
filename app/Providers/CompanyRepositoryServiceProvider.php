<?php

namespace App\Providers;

use App\Contracts\CompanyStore;
use App\Repositories\CompanyRepository;
use Illuminate\Support\ServiceProvider;

class CompanyRepositoryServiceProvider extends ServiceProvider
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
            CompanyStore::class,
            CompanyRepository::class
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
      return [CompanyRepository::class];
    }
}
