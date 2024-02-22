<?php

namespace App\Modules\Preafiliations\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class PreafiliationServiceProvider extends ServiceProvider
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
            'App\Modules\Preafiliations\Repositories\PreafiliationInterface',
            'App\Modules\Preafiliations\Repositories\PreafiliationRepository'
        );
    }
}
