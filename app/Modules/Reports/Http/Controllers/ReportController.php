<?php

namespace App\Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Reports\Http\Requests\OperationResponseRequest;
use App\Modules\Reports\Repositories\ReportInterface;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $report;

    public function __construct(ReportInterface $report)
    {
        $this->model = $report;
    }

    /****************************************************************************/
    public function sales()
    {
        return view('reports::reports.sales', ['identity' => 'Reporte de Ventas']);
    }

    /****************************************************************************/
    public function salesExport(Request $request)
    {
        return $this->model->sales($request);
    }

    public function conciliation()
    {
        return view('reports::reports.conciliation', ['identity' => 'Reporte Administración']);
    }

    /****************************************************************************/
    public function conciliationExport(Request $request)
    {
        return $this->model->conciliation($request);
    }

    /****************************************************************************/
    public function businessSale()
    {
        return view('reports::reports.businesssale', ['identity' => 'Reporte de Inteligencia de Negocios']);
    }

    /****************************************************************************/
    public function businessSaleExport(Request $request)
    {
        return $this->model->businesssale($request);
    }

    /****************************************************************************/
    public function store()
    {
        return view('reports::reports.store', ['identity' => 'Reporte Inventario']);
    }

    /****************************************************************************/
    public function storeExport(Request $request)
    {
        if ($request['type_device'] == 'T') {
            return $this->model->terminal($request);
        }
        if ($request['type_device'] == 'S') {
            return $this->model->simcard($request);
        }

        return redirect()->back();
    }

    /****************************************************************************/
    public function customer()
    {
        return view('reports::reports.customer', ['identity' => 'Reporte de Clientes']);
    }

    /****************************************************************************/
    public function customerExport(Request $request)
    {
        return $this->model->customer($request);
    }

    /****************************************************************************/
    public function preafiliation()
    {
        $model = \App\Modules\Users\Models\User::query();
        $data = $model->select('users.company_id', 'users.id as user_created_id', 'roles.name as slug')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->whereIn('roles.name', ['preafiliation', 'sales', 'assistant'])
            ->where('users.id', \Auth::user()->id)
            ->first();

        return view('reports::reports.preafiliation', ['identity' => 'Reporte de PreAfiliados', 'data' => $data]);
    }

    /****************************************************************************/
    public function preafiliationExport(Request $request)
    {
        return $this->model->preafiliation($request);
    }

    /****************************************************************************/
    public function office()
    {
        return view('reports::reports.office', ['identity' => 'Reporte de Despacho']);
    }

    /****************************************************************************/
    public function officeExport(Request $request)
    {
        return $this->model->office($request);
    }

    /****************************************************************************/
    public function programmer()
    {
        return view('reports::reports.programmer', ['identity' => 'Reporte Programación']);
    }

    /****************************************************************************/
    public function programmerExport(Request $request)
    {
        return $this->model->programmer($request);
    }

    /****************************************************************************/
    public function collection()
    {
        return view('reports::reports.collection', ['identity' => 'Reporte Pagos de Venta']);
    }

    /****************************************************************************/
    public function collectionExport(Request $request)
    {
        return $this->model->collection($request);
    }

    /****************************************************************************/
    public function currencyvalue()
    {
        return view('reports::reports.currencyvalue', ['identity' => 'Reporte de Tasa de Cambio']);
    }

    /****************************************************************************/
    public function currencyvalueExport(Request $request)
    {
        return $this->model->currencyvalue($request);
    }

    /****************************************************************************/
    public function operation()
    {
        return view('reports::reports.operation', ['identity' => 'Reporte Operaciones Diarias']);
    }

    /****************************************************************************/
    public function operationExport(OperationResponseRequest $request)
    {
        if ($request['json'] == 1) {
            return true;
        }

        return $this->model->operation($request);
    }

    /****************************************************************************/
    public function atc()
    {
        return view('reports::reports.atc', ['identity' => 'Reporte Servicio Atención al Cliente']);
    }

    /****************************************************************************/
    public function atcExport(Request $request)
    {
        return $this->model->atc($request);
    }
}
