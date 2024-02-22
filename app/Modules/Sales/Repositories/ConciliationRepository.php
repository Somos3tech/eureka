<?php

namespace App\Modules\Sales\Repositories;

use App\Modules\Operations\Repositories\DashboardInterface;
use App\Modules\Operations\Repositories\OrderInterface;
use App\Modules\Sales\Repositories\CollectionService\CollectionServiceInterface;
use App\Modules\Sales\Repositories\ConciliationService\ConciliationServiceFactory;

class ConciliationRepository implements ConciliationInterface
{
    protected $invoice;

    protected $invoiceitem;

    protected $collection;

    protected $order;

    protected $collect;

    protected $dashboard;

    protected $rcollection;

    public function __construct(InvoiceInterface $invoice, InvoiceItemInterface $invoiceitem, OrderInterface $order, CollectionServiceInterface $collection, CollectionInterface $collect, DashboardInterface $dashboard, RcollectionInterface $rcollection)
    {
        $this->invoice = $invoice;
        $this->invoiceitem = $invoiceitem;
        $this->order = $order;
        $this->collect = $collect;
        $this->collection = $collection;
        $this->dashboard = $dashboard;
        $this->rcollection = $rcollection;
    }

    /*****************************Registrar Conciliación***************************/
    public function manage($request, $id)
    {
        switch ($request['view']) {
            case 'conciliate':
                return $this->conciliate($request, $id);
                break;

            case 'reconciliate':
                return $this->reconciliate($request, $id);
                break;

            default:
                throw new \Exception('Vista No Válida para Conciliar Pago', 1);
                break;
        }
    }

    /**************************************************************************/
    public function conciliate($request, $id)
    {
        if ($request->has('invoiceitem_id')) {
            $this->invoiceitem->update($request, $request['invoiceitem_id']);
            $request['status_invoice'] = $this->invoiceitem->statusInvoice($id);
        }

        if (! $invoice = $this->invoice->update($request, $id)) {
            return false;
        }

        $request['invoice_id'] = (int) $invoice['id'];
        $request['contract_id'] = (int) $invoice['contract_id'];

        if (($request['statusc'] == 'G' && ($request['payment_method'] != 'Postpago' && $request['payment_method'] != 'Comodato') || $request['statusc'] == 'P')) {
            if (! $collection = $this->collection->create($request)) {
                return false;
            }
        }

        if (! $this->order->findContract($request['contract_id'])) {
            if (! $order = $this->order->create($request)) {
                return false;
            }
        }

        return $request;
    }

    /************************************************************************/
    public function reconciliate($request, $id)
    {
        if (! $invoice = $this->invoice->find($id)) {
            return false;
        }

        $invoice = $invoice->toArray();

        $request['invoice_id'] = $id;

        if (! $collection = $this->collection->create($request)) {
            return false;
        }

        return true;
    }

    /************************************************************************/
    public function restore($request, $data)
    {
        $cont = 0;
        $request['payment_method'] = 'pending';

        foreach ($data as $row) {
            if ($row['invoiceitem_id'] != null) {
                $invoiceitem = $this->invoiceitem->update($request, (int) $row['invoiceitem_id']);
            }
        }

        $invoice = $this->invoice->model->select('currency_id', 'amount', 'free', 'amount_currency')
            ->where('invoices.id', '=', (int) $request['invoice_id'])
            ->where('invoices.status', 'C')
            ->first();
        if (isset($invoice)) {
            return $this->invoice->update($request, $request['invoice_id']);
            /*
            $free = $invoice->free != null ? $invoices->free : 0;
              if($invoice->currency_id != 1){
                $amount_exchange = $invoice->amount - $free;
                $amount = ($invoice->amount - $free) * $invoice->amount_currency;
              } else{
                $amount = $invoice->amount - $free;
                $amount_exchange = 0;
              }

              $collection = $this->collect->model->where('collections.invoice_id',(int)$request['invoice_id'])
                                                  ->get()
                                                    ->toArray();

              if(count($collection) > 0){
                $amount_exc_collection = 0;
                $amount_collection = 0;

                foreach ($collection as $row) {
                  $amount_exc_collection = $amount_exc_collection + $row['amount_currency'];
                  $amount_collection = $amount_collection + $row['amount'];
                }


                if(($amount_exchange > 0 && $amount_exchange != $amount_exc_collection) || ($amount_exchange == 0 && $amount != $amount_collection)) {
                  return $this->invoice->update($request, $request['invoice_id']);
               }
            }*/
        }

        return false;
    }

    /**************************************************************************/
    public function storeMasive($request)
    {
        $cont = 0;
        $collection_id = null;
        $status = 'G';

        $conciliationFactory = new ConciliationServiceFactory();
        $masive = $conciliationFactory->initialize($request);
        $data = $masive->insert($request);

        return $data;
    }
}
