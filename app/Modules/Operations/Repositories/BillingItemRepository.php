<?php

namespace App\Modules\Operations\Repositories;

use App\Modules\Operations\Models\BillingItem;
use Auth;

class BillingItemRepository implements BillingItemInterface
{
    protected $billingitem;

    protected $order;

    public function __construct(Billingitem $billingitem, OrderInterface $order)
    {
        $this->model = $billingitem;
        $this->order = $order;
    }

    /***************************Registrar Entrega****************************/
    public function create($request)
    {
        $data = $this->order->findCustomer($request['id']);

        $free = str_replace(',', '', $request['free']);

        if ($free == null || $free == '') {
            $free = 0;
        }
        $result = $this->model->create([
            'billing_id' => $request['billing_id'],
            'contract_id' => $data->contract_id,
            'invoice_id' => $data->invoice_id,
            'order_id' => $data->id,
            'amount' => str_replace(',', '', $request['amount_billing']),
            'iva' => 16,
            'free' => $free,
            'amount_currency' => str_replace(',', '', $data->amount_currency),
            'amount_sim' => null,
            'terminal_id' => $data->terminal_id,
            'simcard_id' => $data->simcard_id,
            'observation' => $request['observation'],
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            $result['status'] = $data->status_order;

            return $result;
        }

        return false;
    }

    /**************************Buscar Información Entrega********************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /**************************Buscar Información Entrega********************/
    public function findBillingItem($id)
    {
        $data = $this->model->select('billingitems.id', \DB::raw("CONCAT('Modelo -> ',mt.description,' Serial -> ', t.serial) as description"), \DB::raw('FORMAT(((billingitems.amount/1.16)-billingitems.free),2) as base'), \DB::raw('FORMAT(((billingitems.amount/1.16)-billingitems.free)*0.16,2) as iva'), \DB::raw('FORMAT(((billingitems.amount/1.16)-billingitems.free)+(((billingitems.amount/1.16)-billingitems.free)*0.16),2) as amount'))
            ->join('terminals as t', function ($join) {
                $join->on('t.id', '=', 'billingitems.terminal_id');
                $join->whereNull('t.deleted_at');
            })
            ->join('modelterminal as mt', function ($join) {
                $join->on('mt.id', '=', 't.modelterminal_id');
                $join->whereNull('mt.deleted_at');
            })
            ->where('billingitems.billing_id', '=', $id)
            ->get();
        if ($data) {
            return \Response::json($data);
        }

        return '[]';
    }

    /***************************Actualizar Entrega***************************/
    public function update($request, $id)
    {
    }

    /****************************Anular Facturas*****************************/
    public function delete($id)
    {
        $cont = 0;
        $query = $this->model->select('billingitems.id')->where('billing_id', '=', $id)->get();
        foreach ($query as $row) {
            $model = $this->model->findOrfail($row->id);
            $model->user_deleted_id = Auth::user()->id;
            if ($model->update()) {
                if ($model->delete()) {
                    $cont++;
                }
            }
        }

        if ($cont > 0) {
            return true;
        }

        return false;
    }

    /***************************Datatable Facturas****************************/
    public function datatable()
    {
        $model = $this->model->query();
        $data = $model->query()->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                $actions = '<center>';

                $date_now = Carbon::now()->format('Y-m');

                if ($data->billing_created == $date_now) {
                    if (\Shinobi::can('billings.destroy')) {
                        $actions .= '<button class="btn btn-sm btn-danger waves-effect waves-light" href="#" data-toggle="modal" OnClick="BillingDelete(this);" data-target="#deleteBilling" value="'.$data->id.'" title="Anular Factura"><i class="fa fa-trash"></i></button>';
                    }
                }
                $actions .= '&nbsp; <button class="btn btn-sm btn-info waves-effect waves-light" href="#" data-toggle="modal" OnClick="OrderShow(this);" data-target="#showOrder" value="'.$data->order_id.'" title="Gestión Orden de Servicio"><i class="ion-information-circled"></i></button>';

                $actions .= '&nbsp; <button class="btn btn-sm btn-secondary waves-effect waves-light" data-toggle="modal" value="'.$data->id.'" OnClick="showBilling(this);" data-target=".billing" title="Ver Factura""><i class="fa fa-file-pdf-o"></i></button>';
                $actions .= '&nbsp; <button class="btn btn-sm btn-secondary waves-effect waves-light" data-toggle="modal" value="'.$data->id.'" OnClick="showBillingN(this);" data-target=".billing" title="Imprimir Factura"><i class="fa fa-print"></i></button>';
                $actions .= '</center>';

                return $actions;
            })->rawColumns(['management', 'actions'])
            ->toJson();
    }

    /**************************************************************************/
    public function api()
    {
        //
    }
}
