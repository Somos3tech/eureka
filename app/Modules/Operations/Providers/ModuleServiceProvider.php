<?php

namespace App\Modules\Operations\Providers;

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
        $this->loadTranslationsFrom(module_path('operations', 'Resources/Lang', 'app'), 'operations');
        $this->loadViewsFrom(module_path('operations', 'Resources/Views', 'app'), 'operations');
        $this->loadMigrationsFrom(module_path('operations', 'Database/Migrations', 'app'));
        if (! $this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('operations', 'Config', 'app'));
        }
        $this->loadFactoriesFrom(module_path('operations', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(OperationServiceProvider::class);
    }
}
