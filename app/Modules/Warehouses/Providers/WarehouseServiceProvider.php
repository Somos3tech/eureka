<?php

namespace App\Modules\Warehouses\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class WarehouseServiceProvider extends ServiceProvider
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
            'App\Modules\Warehouses\Repositories\TerminalInterface',
            'App\Modules\Warehouses\Repositories\TerminalRepository'
        );

        $this->app->bind(
            'App\Modules\Warehouses\Repositories\SimcardInterface',
            'App\Modules\Warehouses\Repositories\SimcardRepository'
        );

        $this->app->bind(
            'App\Modules\Warehouses\Repositories\Assignment\AssignmentInterface',
            'App\Modules\Warehouses\Repositories\Assignment\AssignmentRepository'
        );

        $this->app->bind(
            'App\Modules\Warehouses\Repositories\Assignment\ReassignInterface',
            'App\Modules\Warehouses\Repositories\Assignment\ReassignRepository'
        );

        $this->app->bind(
            'App\Modules\Warehouses\Repositories\Assignment\AssignmentServiceInterface'
        );
    }
}
