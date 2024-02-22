<?php

namespace App\Modules\Warehouses\Providers;

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
        $this->loadTranslationsFrom(module_path('warehouses', 'Resources/Lang', 'app'), 'warehouses');
        $this->loadViewsFrom(module_path('warehouses', 'Resources/Views', 'app'), 'warehouses');
        $this->loadMigrationsFrom(module_path('warehouses', 'Database/Migrations', 'app'));
        if (! $this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('warehouses', 'Config', 'app'));
        }
        $this->loadFactoriesFrom(module_path('warehouses', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(WarehouseServiceProvider::class);
    }
}
