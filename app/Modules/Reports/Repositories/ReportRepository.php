<?php

namespace App\Modules\Reports\Repositories;

use App\Modules\Customers\Repositories\CustomerInterface;
use App\Modules\Operations\Repositories\OrderInterface;
use App\Modules\Parameters\Repositories\CurrencyValueInterface;
use App\Modules\Preafiliations\Repositories\PreafiliationInterface;
use App\Modules\Sales\Repositories\CollectionInterface;
use App\Modules\Sales\Repositories\Operation\OperationInterface;
use App\Modules\Sales\Repositories\SaleInterface;
use App\Modules\Supports\Repositories\AtcInterface;
use App\Modules\Warehouses\Repositories\SimcardInterface;
use App\Modules\Warehouses\Repositories\TerminalInterface;

class ReportRepository implements ReportInterface
{
    protected $sale;

    protected $customer;

    protected $preafiliation;

    protected $terminal;

    protected $simcard;

    protected $order;

    protected $collection;

    protected $currencyvalue;

    protected $operation;

    protected $atc;

    /**
     * ReportsRepository constructor.
     *
     * @param  Report  $report
     */
    /************************************************************************/
    public function __construct(
        SaleInterface $sale,
        CustomerInterface $customer,
        PreafiliationInterface $preafiliation,
        TerminalInterface $terminal,
        SimcardInterface $simcard,
        OrderInterface $order,
        CollectionInterface $collection,
        CurrencyValueInterface $currencyvalue,
        OperationInterface $operation,
        AtcInterface $atc
    ) {
        $this->sale = $sale;
        $this->customer = $customer;
        $this->preafiliation = $preafiliation;
        $this->terminal = $terminal;
        $this->simcard = $simcard;
        $this->order = $order;
        $this->collection = $collection;
        $this->currencyvalue = $currencyvalue;
        $this->operation = $operation;
        $this->atc = $atc;
    }

    /************************************************************************/
    public function preafiliation($request)
    {
        return $this->preafiliation->report($request);
    }

    /************************************************************************/
    public function customer($request)
    {
        return $this->customer->report($request);
    }

    /************************************************************************/
    public function sales($request)
    {
        return $this->sale->report($request);
    }

    /************************************************************************/
    public function businesssale($request)
    {
        return $this->sale->reportbusiness($request);
    }

    /************************************************************************/
    public function terminal($request)
    {
        return $this->terminal->report($request);
    }

    /************************************************************************/
    public function simcard($request)
    {
        return $this->simcard->report($request);
    }

    /************************************************************************/
    public function office($request)
    {
        return $this->order->reportOffice($request);
    }

    /************************************************************************/
    public function programmer($request)
    {
        return $this->order->reportAdminProgrammer($request);
    }

    /************************************************************************/
    public function collection($request)
    {
        return $this->collection->report($request);
    }

    /************************************************************************/
    public function currencyvalue($request)
    {
        return $this->currencyvalue->report($request);
    }

    /************************************************************************/
    public function operation($request)
    {
        return $this->operation->report($request);
    }

    /************************************************************************/
    public function atc($request)
    {
        return $this->atc->report($request);
    }

    /************************************************************************/
    public function conciliation($request)
    {
        return $this->sale->reportconciliation($request);
    }
}
