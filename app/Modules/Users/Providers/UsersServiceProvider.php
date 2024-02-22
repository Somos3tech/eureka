<?php

namespace App\Modules\Users\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Modules\Users\Repositories\User\UserInterface',
            'App\Modules\Users\Repositories\User\UserRepository'
        );

        $this->app->bind(
            'App\Modules\Users\Repositories\Role\RoleInterface',
            'App\Modules\Users\Repositories\Role\RoleRepository'
        );

        $this->app->bind(
            'App\Modules\Users\Repositories\Permission\PermissionInterface',
            'App\Modules\Users\Repositories\Permission\PermissionRepository'
        );
    }
}
