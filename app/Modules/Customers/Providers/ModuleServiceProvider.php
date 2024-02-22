<?php

namespace App\Modules\Customers\Providers;

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
        $this->loadTranslationsFrom(module_path('customers', 'Resources/Lang', 'app'), 'customers');
        $this->loadViewsFrom(module_path('customers', 'Resources/Views', 'app'), 'customers');
        $this->loadMigrationsFrom(module_path('customers', 'Database/Migrations', 'app'));
        if (! $this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('customers', 'Config', 'app'));
        }
        $this->loadFactoriesFrom(module_path('customers', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(CustomerServiceProvider::class);
    }
}
