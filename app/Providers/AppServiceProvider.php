<?php

namespace App\Providers;

use App\Services\UserService;
use \App\Services\Impl\UserServiceImpl;
use App\Repositories\Impl\UserRepositoryImpl;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepository::class,
            UserRepositoryImpl::class
        );

        $this->app->bind(
            UserService::class,
            UserServiceImpl::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
