<?php

namespace App\Modules\Supports\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
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
            'App\Modules\Supports\Repositories\CsupportInterface',
            'App\Modules\Supports\Repositories\CsupportRepository'
        );

        $this->app->bind(
            'App\Modules\Supports\Repositories\SupportInterface',
            'App\Modules\Supports\Repositories\SupportRepository',
            'App\Modules\Supports\Repositories\Support\SupportServiceInterface'
        );

        $this->app->bind(
            'App\Modules\Supports\Repositories\AtcInterface',
            'App\Modules\Supports\Repositories\AtcRepository'
        );

        $this->app->bind(
            'App\Modules\Supports\Repositories\AtcmessageInterface',
            'App\Modules\Supports\Repositories\AtcmessageRepository'
        );

        $this->app->bind(
            'App\Modules\Supports\Repositories\ManagementtypeInterface',
            'App\Modules\Supports\Repositories\ManagementtypeRepository'
        );

        $this->app->bind(
            'App\Modules\Supports\Repositories\MtypeitemInterface',
            'App\Modules\Supports\Repositories\MtypeitemRepository'
        );

        $this->app->bind(
            'App\Modules\Supports\Repositories\ChannelInterface',
            'App\Modules\Supports\Repositories\ChannelRepository'
        );
    }
}
