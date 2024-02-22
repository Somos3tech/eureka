<?php

namespace App\Modules\Supports\Providers;

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
        $this->loadTranslationsFrom(module_path('supports', 'Resources/Lang', 'app'), 'supports');
        $this->loadViewsFrom(module_path('supports', 'Resources/Views', 'app'), 'supports');
        $this->loadMigrationsFrom(module_path('supports', 'Database/Migrations', 'app'));
        if (! $this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('supports', 'Config', 'app'));
        }
        $this->loadFactoriesFrom(module_path('supports', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(SupportServiceProvider::class);
    }
}
