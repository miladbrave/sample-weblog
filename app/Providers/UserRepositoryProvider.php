<?php

namespace App\Providers;

use App\Repositories\Interfaces\PostRepositoriesInterface;
use App\Repositories\Interfaces\TagRepositoriesInterface;
use App\Repositories\Interfaces\UserRepositoriesInterface;
use App\Repositories\PostRepositories;
use App\Repositories\TagRepositories;
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
        $this->app->singleton(PostRepositoriesInterface::class,PostRepositories::class);
        $this->app->singleton(TagRepositoriesInterface::class,TagRepositories::class);
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
