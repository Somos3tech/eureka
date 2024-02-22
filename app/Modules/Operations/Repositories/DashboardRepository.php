<?php

namespace App\Modules\Operations\Repositories;

use App\Modules\Customers\Repositories\CustomerInterface;
use App\Modules\Sales\Repositories\ContractInterface;
use App\Modules\Sales\Repositories\InvoiceInterface;

class DashboardRepository implements DashboardInterface
{
    protected $customer;

    protected $contract;

    protected $invoice;

    protected $order;

    public function __construct(CustomerInterface $customer, ContractInterface $contract, InvoiceInterface $invoice, OrderInterface $order)
    {
        $this->customer = $customer;
        $this->contract = $contract;
        $this->invoice = $invoice;
        $this->order = $order;
    }

    /********************************Registrar Contrato****************************/
    public function index()
    {
        $customer = $this->customer->totalCustomer();
        $contract = $this->contract->totalContract();
        $invoice = $this->invoice->totalInvoice();
        $order = $this->order->totalOrder();

        $data = array_merge($customer, $contract, $invoice, $order);

        return $data;
    }
}
