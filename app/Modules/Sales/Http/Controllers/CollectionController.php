<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Repositories\PayerInterface;
use App\Modules\Sales\Exports\CollectionBankOrderReportExport;
use App\Modules\Sales\Exports\CollectionBankReportExport;
//Repository Collection dentro de Modulo
use App\Modules\Sales\Http\Requests\InvoiceConciliateRequest;
use App\Modules\Sales\Repositories\CollectionInterface;
use App\Modules\Sales\Repositories\ConciliationInterface;
use App\Modules\Supports\Repositories\CsupportInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;

class CollectionController extends Controller
{
    protected $collection;

    protected $conciliation;

    protected $csupport;

    protected $payer;

    public function __construct(
        CollectionInterface $collection,
        ConciliationInterface $conciliation,
        CsupportInterface $csupport,
        PayerInterface $payer
    ) {
        $this->model = $collection;
        $this->conciliation = $conciliation;
        $this->csupport = $csupport;
        $this->payer = $payer;
    }

    /**************************************************************************/
    public function create()
    {
        return View('sales::collections.create', ['identity' => 'Conciliación de Cobro']);
    }

    /***********************Guardar Registro Cobro******************************/
    public function store(InvoiceConciliateRequest $request)
    {
        if ($result = $this->conciliation->manage($request, $request['invoice_id'])) {

            ////////////////////////////////////////////////////////////
            //AGREGADO ALCIDES DA SILVA 01/06/2023
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://192.168.0.23:9191/profit/GrabarCotizacion/' . $request['invoice_id']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            /////////////////////////////////////////////////////////////

            $this->csupport->validAffiliate($result->all());
            toastr()->info('Pago del Cobro Conciliado Correctamente');
            return redirect()->to('invoices/' . $request->route);
        }
        toastr()->error('Error al Conciliar Pago del Cobro');

        return redirect()->back();
    }

    /************************Ver Registro Detalle Cobro************************/
    public function show(Request $request, $id)
    {
        return $this->model->findId($request, $id);
    }

    /************************Ver Registro Detalle Cobro************************/
    public function delete()
    {
        return view('sales::collections.delete', ['identity' => 'Anular Pago']);
    }

    /*************************Eliminar Detalle Cobro***************************/
    public function destroyCollect(Request $request)
    {
        $collection = $this->model->deleteCollect($request);
        if (isset($collection)) {
            $this->conciliation->restore($request->all(), $collection);
            toastr()->info('Se ha Anulado Correctamente el(los) Pago(s) de Cobro');

            return redirect()->back();
        }
        toastr()->error('Error al Anular el(los) Pago(s) de Cobro');

        return redirect()->back()->withInput();
    }

    /**************************************************************************/
    public function serviceMasive()
    {
        return view('sales::collections.masive', ['identity' => 'Conciliación Masiva Servicios']);
    }

    /**************************************************************************/
    public function storeMasive(Request $request)
    {
        if ($data = $this->conciliation->storeMasive($request)) {
            toastr()->info('Se Cargo Resultados de Cobros Bancarios x Servicio Correctamente');
            $payer = $this->payer->model->where('payers.bank_id', $request['bank_id'])->where('payers.type_file', 'LIKE', 'domiciliation')->first();
            if ($payer) {
                return Excel::download(new CollectionBankOrderReportExport(Collect($data), $request), 'Resultado Gestión Cobranza Bancaria Diaria Masiva  ' . date('Y-m-d') . '.xlsx');
            }

            return Excel::download(new CollectionBankReportExport(Collect($data)), 'Resultado Gestión Cobranza Bancaria Diaria Masiva  ' . date('Y-m-d') . '.xlsx');
        }
        toastr()->error('Error en la Carga de los Resultados de Cobros Bancarios x Servicio');
    }

    /**************************************************************************/
    public function reportService()
    {
        return view('sales::invoices.services.reports.collection', ['identity' => 'Reporte Pago - Cobro Servicios']);
    }

    /**************************************************************************/
    public function reportServiceExport(Request $request)
    {
        return $this->model->reportService($request);
    }
}
