<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Http\Requests\InvoiceCreateRequest;
use App\Modules\Sales\Repositories\ConciliationInterface;
use App\Modules\Sales\Repositories\InvoiceInterface;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $invoice;

    private $conciliation;

    public function __construct(InvoiceInterface $invoice, ConciliationInterface $conciliation)
    {
        $this->model = $invoice;
        $this->conciliation = $conciliation;
    }

    /*************************Dashboard Conciliación***************************/
    public function index()
    {
        return View('sales::invoices.index')->with('identity', 'Dashboard Cobros');
    }

    /*****************************Datatable Cobro******************************/
    public function datatable(Request $request)
    {
        return $this->model->datatable($request);
    }

    /******************************Financiamiento******************************/
    public function financing()
    {
        return view('sales::invoices.financing', ['identity' => 'Dashboard Cobros Financiamiento']);
    }

    /*****************************Datatable Cobro******************************/
    public function datatableFinancing()
    {
        return $this->model->datatableFinancing();
    }

    /**************************************************************************/
    public function postpago()
    {
        return View('sales::invoices.postpago')->with('identity', 'Dashboard Cobros Postpago');
    }

    /************************Datatable Cobro x Usuario*************************/
    public function datatableUser(Request $request)
    {
        return $this->model->datatable($request);
    }

    /**************************************************************************/
    public function create()
    {
        return View('sales::invoices.create')->with('identity', 'Registrar Cobro');
    }

    /***********************Guardar Registro Cobro******************************/
    public function store(InvoiceCreateRequest $request)
    {
        if (! $model = $this->model->create($request)) {
            toastr()->error('Error al Registrar el Cobro');

            return redirect()->back()->withInput();
        }
        toastr()->info('Se ha registrado correctamente el Cobro del Punto de Venta No.Cobro: '.$model->id);

        return redirect()->back();
    }

    /*************Verificar - Crear Registro Contrato de Venta*****************/
    public function edit()
    {
        return View('sales::invoices.edit', ['identity' => 'Soporte Cobro(s)']);
    }

    /************************Guardar Registro Cobro****************************/
    public function update(Request $request, $id)
    {
        if (! $this->conciliation->manage($request, $id)) {
            toastr()->error('Error al Conciliar Pago del Cobro');

            return redirect()->back();
        }
        toastr()->info('Pago del Cobro Conciliado Correctamente');

        return redirect()->to('invoices/');
    }

    /**************************************************************************/
    public function updateApi(Request $request, $id)
    {
        if ($this->conciliation->conciliate($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Pago del Cobro Conciliado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Conciliar Pago']);
    }

    /**************************ver Registro Cobro******************************/
    public function show(Request $request, $id)
    {
        if ($request->has('valid')) {
            return $this->model->findValid($id);
        }

        return $this->model->find((int) $id);
    }

    /**************************ver Registro Cobro******************************/
    public function find(Request $request)
    {
        return $this->model->findInvoice($request);
    }

    /**************************ver Registro Cobro******************************/
    public function findInvoiceId(Request $request)
    {
        return $this->model->findInvoiceId($request['invoice_id']);
    }

    /**************************************************************************/
    public function findService(Request $request)
    {
        return $this->model->findService($request);
    }

    /****************Visualizar Documento de Soporte de Pago*******************/
    public function viewDocument($id)
    {
        return $this->model->viewDocument($id);
    }

    /*********************Visualizar Documento Cobro***************************/
    public function viewPDF($id)
    {
        return $this->model->viewPDF($id);
    }

    /**************************************************************************
        public function serviceCreate(){
            return View('sales::invoices.services.create')->with('identity','Módulo Cobranza');
        }*/
    /**************************************************************************/
    public function totalInvoice()
    {
        return $this->model->totalInvoice();
    }
}
