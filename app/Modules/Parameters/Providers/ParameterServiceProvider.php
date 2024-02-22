<?php

namespace App\Modules\Parameters\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ParameterServiceProvider extends ServiceProvider
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
            'App\Modules\Parameters\Repositories\AcconceptInterface',
            'App\Modules\Parameters\Repositories\AcconceptRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\ApnInterface',
            'App\Modules\Parameters\Repositories\ApnRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\BankInterface',
            'App\Modules\Parameters\Repositories\BankRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\BusinessInterface',
            'App\Modules\Parameters\Repositories\BusinessRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\ComissionInterface',
            'App\Modules\Parameters\Repositories\ComissionRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\CompanyInterface',
            'App\Modules\Parameters\Repositories\CompanyRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\ConceptInterface',
            'App\Modules\Parameters\Repositories\ConceptRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\ConsultantInterface',
            'App\Modules\Parameters\Repositories\ConsultantRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\CurrencyInterface',
            'App\Modules\Parameters\Repositories\CurrencyRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\CurrencyValueInterface',
            'App\Modules\Parameters\Repositories\CurrencyValueRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\MarkInterface',
            'App\Modules\Parameters\Repositories\MarkRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\MterminalInterface',
            'App\Modules\Parameters\Repositories\MterminalRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\OperatorInterface',
            'App\Modules\Parameters\Repositories\OperatorRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\PmethodInterface',
            'App\Modules\Parameters\Repositories\PmethodRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\TermInterface',
            'App\Modules\Parameters\Repositories\TermRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\TerminalValueInterface',
            'App\Modules\Parameters\Repositories\TerminalValueRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\TipificationInterface',
            'App\Modules\Parameters\Repositories\TipificationRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\TypeCompanyInterface',
            'App\Modules\Parameters\Repositories\TypeCompanyRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\CactivityInterface',
            'App\Modules\Parameters\Repositories\CactivityRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\ZoneRoleInterface',
            'App\Modules\Parameters\Repositories\ZoneRoleRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\PayerInterface',
            'App\Modules\Parameters\Repositories\PayerRepository'
        );

        $this->app->bind(
            'App\Modules\Parameters\Repositories\Select'
        );

        $this->app->validator->resolver(function ($translator, $data, $rules, $messages) {
            return new CustomValidation($translator, $data, $rules, $messages);
        });
    }
}
