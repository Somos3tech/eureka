<?php

namespace App\Modules\Reports\Providers;

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
        $this->loadTranslationsFrom(module_path('reports', 'Resources/Lang', 'app'), 'reports');
        $this->loadViewsFrom(module_path('reports', 'Resources/Views', 'app'), 'reports');
        $this->loadMigrationsFrom(module_path('reports', 'Database/Migrations', 'app'));
        if (! $this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('reports', 'Config', 'app'));
        }
        $this->loadFactoriesFrom(module_path('reports', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ReportServiceProvider::class);
    }
}
