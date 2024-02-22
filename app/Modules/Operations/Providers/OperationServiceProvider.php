<?php

namespace App\Modules\Operations\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class OperationServiceProvider extends ServiceProvider
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
            'App\Modules\Operations\Repositories\OrderInterface',
            'App\Modules\Operations\Repositories\OrderRepository'
        );

        $this->app->bind(
            'App\Modules\Operations\Repositories\SocketInterface',
            'App\Modules\Operations\Repositories\SocketRepository'
        );

        $this->app->bind(
            'App\Modules\Operations\Repositories\DashboardInterface',
            'App\Modules\Operations\Repositories\DashboardRepository'
        );

        $this->app->bind(
            'App\Modules\Operations\Repositories\Service\ServiceInterface',
            'App\Modules\Operations\Repositories\Service\ServiceRepository'
        );

        $this->app->validator->resolver(function ($translator, $data, $rules, $messages) {
            return new CustomValidation($translator, $data, $rules, $messages);
        });

        $this->app->bind(
            'App\Modules\Operations\Repositories\Transfer\TransferInterface',
            'App\Modules\Operations\Repositories\Transfer\TransferRepository'
        );

        $this->app->bind(
            'App\Modules\Operations\Repositories\BillingInterface',
            'App\Modules\Operations\Repositories\BillingRepository'
        );

        $this->app->bind(
            'App\Modules\Operations\Repositories\BillingItemInterface',
            'App\Modules\Operations\Repositories\BillingItemRepository'
        );
    }
}
