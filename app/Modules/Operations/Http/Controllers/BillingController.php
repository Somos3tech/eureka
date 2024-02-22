<?php

namespace App\Modules\Operations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Operations\Repositories\BillingInterface;
//Repository  Billing dentro de Modulo
use App\Modules\Operations\Repositories\BillingItemInterface;
use App\Modules\Operations\Repositories\OrderInterface;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    protected $order;

    protected $billing;

    protected $billingitem;

    public function __construct(BillingInterface $billing, BillingItemInterface $billingitem, OrderInterface $order)
    {
        $this->model = $billing;
        $this->billingitem = $billingitem;
        $this->order = $order;
    }

    /****************************************************************************/
    public function index()
    {
        return view('operations::billings.index', ['identity' => 'Dashboard Facturación']);
    }

    /****************************************************************************/
    public function create()
    {
        return view('operations::billings.create', ['identity' => 'Generar Factura']);
    }

    /****************************************************************************/
    public function show($id)
    {
        return $this->model->find($id);
    }

    /****************************************************************************/
    public function store(Request $request)
    {
        $cont = 0;
        if ($model = $this->model->create($request)) {
            foreach ($request['order_id'] as $row) {
                $request['billing_id'] = $model->id;
                $request['id'] = $row;
                $request['amount_billing'] = $request['amount'][$cont];

                if ($billingitem = $this->billingitem->create($request)) {
                    if ($billingitem->status == 'Almacén - Sin Facturar') {
                        $request['type_service'] = 'Billing';
                        $request['contract_id'] = $billingitem->contract_id;
                        $data = $this->service->management($request, $billingitem->order_id);
                    }
                    $cont++;
                }
            }
            if ($cont > 0) {
                return redirect()->to('/billings')->with(['info' => 'Factura Generada  Correctamente No.'.$model->id]);
            }
        }

        return redirect()->back()->with(['message' => 'Error al Generar Factura']);
    }

    /***************************************************************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /****************************************************************************/
    public function destroy($id)
    {
        if ($billing = $this->model->delete($id)) {
            if ($billingitem = $this->billingitem->delete($billing->id)) {
                return response()->json(['success' => 'true', 'message' => 'Factura No. '.$billing->id.' Anulada Correctamente']);
            }
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Anular Factura']);
    }

    /****************************************************************************/
    public function select()
    {
        return $this->model->api();
    }

    /****************************************************************************/
    public function pdf()
    {
        return $this->model->pdf();
    }
}
