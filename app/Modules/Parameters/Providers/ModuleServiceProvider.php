<?php

namespace App\Modules\Parameters\Providers;

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
        $this->loadTranslationsFrom(module_path('parameters', 'Resources/Lang', 'app'), 'parameters');
        $this->loadViewsFrom(module_path('parameters', 'Resources/Views', 'app'), 'parameters');
        $this->loadMigrationsFrom(module_path('parameters', 'Database/Migrations', 'app'));
        if (! $this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('parameters', 'Config', 'app'));
        }
        $this->loadFactoriesFrom(module_path('parameters', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ParameterServiceProvider::class);
    }
}
