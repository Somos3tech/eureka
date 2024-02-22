<?php

namespace App\Modules\Customers\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
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
            'App\Modules\Customers\Repositories\CustomerInterface',
            'App\Modules\Customers\Repositories\CustomerRepository'
        );

        $this->app->bind(
            'App\Modules\Customers\Repositories\DcustomerInterface',
            'App\Modules\Customers\Repositories\DcustomerRepository'
        );

        $this->app->bind(
            'App\Modules\Customers\Repositories\RcustomerInterface',
            'App\Modules\Customers\Repositories\RcustomerRepository'
        );

        $this->app->bind(
            'App\Modules\Customers\Repositories\Customer\CustomerServiceInterface',
            'App\Modules\Customers\Repositories\Customer\CustomerBasic'
        );
    }
}
