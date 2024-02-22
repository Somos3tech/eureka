<?php

namespace App\Modules\Sales\Repositories;

use App\Modules\Sales\Models\InvoiceItem;
use App\Modules\Sales\Repositories\Payment\InvoiceItemFactory;
use Auth;

class InvoiceItemRepository implements InvoiceItemInterface
{
    protected $invoiceItem;

    /**
     * InvoiceItemRepository constructor.
     *
     * @param  InvoiceItem  $invoiceItem
     */
    public function __construct(InvoiceItem $invoiceItem)
    {
        $this->model = $invoiceItem;
    }

    /****************************Registrar InvoiceItem*****************************/
    public function create($request)
    {
        $sum = 0;

        $invoiceItemFactory = new InvoiceItemFactory();
        $payment = $invoiceItemFactory->initialize($request['payment_method']);
        $valid_data = $payment->pay($request);

        $request_data = [
            'invoice_id' => $request['invoice_id'],
            'fechpro' => date('Y-m-d'),
            'user_created_id' => Auth::user()->id,
            'user_updated_id' => Auth::user()->id,
        ];

        foreach ($valid_data as $row) {
            if ($result = $this->model->create(array_merge($row, $request_data))) {
                $sum++;
            }
        }

        if ($sum > 0) {
            return $result;
        }

        return false;
    }

    /*************************Registrar InvoiceItem**************************/
    public function update($request, $id)
    {
        $model = $this->model->where('invoiceitems.id', '=', (int) $id)->first();
        if (isset($model)) {
            $data = $this->hasValid($request);
            $result = $model->update($data);

            if ($result) {
                return $model;
            }
        }

        return false;
    }

    /************************************************************************/
    private function hasValid($request)
    {
        if ($request['payment_method'] == 'pending') {
            $data = [
                'status' => 'P',
                'user_updated_id' => Auth::user()->id,
            ];
        } else {
            $data = [
                'status' => 'C',
                'user_updated_id' => Auth::user()->id,
            ];
        }

        return $data;
    }

    /************************************************************************/
    public function findInvoice($request, $id)
    {
        $model = $this->model->query();

        $model->select(
            'cu.abrev as currency',
            'invoiceitems.id',
            'invoiceitems.invoice_id',
            'invoiceitems.fechpro',
            'invoiceitems.currency_id',
            'invoiceitems.item',
            'invoiceitems.concept',
            \DB::raw(' FORMAT(invoiceitems.amount,2) as amount'),
            \DB::raw(" (CASE WHEN (invoiceitems.amount_currency IS NULL) THEN '----' ELSE FORMAT(invoiceitems.amount_currency,2) END) as amount_currency"),
            'invoiceitems.date_expire',
            'invoiceitems.status'
        )
            ->join('currencies as cu', 'cu.id', '=', 'invoiceitems.currency_id')
            ->where('invoiceitems.invoice_id', '=', $id);

        if ($request['invoiceitem_id'] != '') {
            $model->where('invoiceitems.id', Input::get('invoiceitem_id'));
        }

        if ($request['view'] == 'reconciliate') {
            $model->whereIn('invoiceitems.status', ['C']);
        } elseif ($request['view'] == 'conciliate') {
            $model->whereIn('invoiceitems.status', ['G', 'P']);
        }

        return $model->get();
    }

    public function find($request)
    {
        if ($request['invoiceitem_id']) {
            $model = $this->model->query();

            $model->select(
                'cu.abrev as currency',
                \DB::raw("LPAD(invoiceitems.id,7,'0') as id"),
                'invoiceitems.invoice_id',
                'invoiceitems.fechpro',
                'invoiceitems.currency_id',
                'invoiceitems.item',
                'invoiceitems.concept',
                \DB::raw(' FORMAT(invoiceitems.amount,2) as amount'),
                \DB::raw(" (CASE WHEN (invoiceitems.amount_currency IS NULL) THEN '----' ELSE FORMAT(invoiceitems.amount_currency,2) END) as amount_currency"),
                'invoiceitems.date_expire',
                'invoiceitems.status'
            )
                ->join('currencies as cu', 'cu.id', '=', 'invoiceitems.currency_id');
            if ($request['invoiceitem_id'] != '') {
                $model->where('invoiceitems.id', $request['invoiceitem_id']);
            }

            return $model->first();
        } else {
            return '';
        }
    }

    /************************************************************************/
    public function statusInvoice($id)
    {
        $model = $this->model->query();

        $data = $model->select(\DB::raw('COUNT(*) as total'))->where('invoiceitems.invoice_id', '=', (int) $id)->where('invoiceitems.status', '!=', 'C')->first();

        if ($data->total > 0) {
            return false;
        }

        return true;
    }

    /*************************Eliminar Invoice*******************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;

        if ($model->update()) {
            if ($model->delete()) {
                return true;
            }
        }

        return false;
    }
}
