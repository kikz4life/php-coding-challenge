<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RandomUserApiService;
use App\Services\CustomerImporterService;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(RandomUserApiService::class, fn($app) => new RandomUserApiService());
        $this->app->singleton(CustomerImporterService::class, fn($app) =>
            new CustomerImporterService(
                $app->make('Doctrine\ORM\EntityManagerInterface'),
                $app->make(RandomUserApiService::class)
            )
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
