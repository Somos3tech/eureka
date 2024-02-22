<?php

namespace App\Modules\Sales\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SaleServiceProvider extends ServiceProvider
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
            'App\Modules\Sales\Repositories\ContractInterface',
            'App\Modules\Sales\Repositories\ContractRepository',
            'App\Modules\Sales\Repositories\ContractService\ContractServiceInterface',
            'App\Modules\Sales\Repositories\ContractService\ContractServiceFactory'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\InvoiceInterface',
            'App\Modules\Sales\Repositories\InvoiceRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\InvoiceItemInterface',
            'App\Modules\Sales\Repositories\InvoiceItemRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\InvoiceMasiveInterface',
            'App\Modules\Sales\Repositories\InvoiceMasiveRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\CollectionInterface',
            'App\Modules\Sales\Repositories\CollectionRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\RcollectionInterface',
            'App\Modules\Sales\Repositories\RcollectionRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\CollectionService\CollectionServiceInterface',
            'App\Modules\Sales\Repositories\CollectionService\CollectionServiceRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\SaleInterface',
            'App\Modules\Sales\Repositories\SaleRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\ConciliationInterface',
            'App\Modules\Sales\Repositories\ConciliationRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\Operation\OperationInterface',
            'App\Modules\Sales\Repositories\Operation\OperationRepository'
        );
        $this->app->bind(
            'App\Modules\Sales\Repositories\Operterminal\OperterminalInterface',
            'App\Modules\Sales\Repositories\Operterminal\OperterminalRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\Payment\PaylableInterface',
            'App\Modules\Sales\Repositories\Conciliation\ConciliationInterface'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\RaffiliateInterface',
            'App\Modules\Sales\Repositories\RaffiliateRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\ConsecutiveInterface',
            'App\Modules\Sales\Repositories\ConsecutiveRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\AconsecutiveInterface',
            'App\Modules\Sales\Repositories\AconsecutiveRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\StatementInterface',
            'App\Modules\Sales\Repositories\StatementRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\DomiciliationInterface',
            'App\Modules\Sales\Repositories\DomiciliationRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\AdomiciliationInterface',
            'App\Modules\Sales\Repositories\AdomiciliationRepository'
        );

        $this->app->bind(
            'App\Modules\Sales\Repositories\Service\SupportInvoiceInterface'
        );
    }
}
