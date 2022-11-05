<?php

namespace App\Providers;

use App\Repositories\Interfaces\UserRepositoriesInterface;
use App\Repositories\UserRepositories;
use Illuminate\Support\ServiceProvider;

class UserRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepositoriesInterface::class,UserRepositories::class);
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
