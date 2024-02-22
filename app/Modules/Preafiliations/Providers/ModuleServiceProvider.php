<?php

namespace App\Modules\Preafiliations\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('preafiliations', 'Resources/Lang', 'app'), 'preafiliations');
        $this->loadViewsFrom(module_path('preafiliations', 'Resources/Views', 'app'), 'preafiliations');
        $this->loadMigrationsFrom(module_path('preafiliations', 'Database/Migrations', 'app'));
        if (! $this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('preafiliations', 'Config', 'app'));
        }
        $this->loadFactoriesFrom(module_path('preafiliations', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(PreafiliationServiceProvider::class);
    }
}
