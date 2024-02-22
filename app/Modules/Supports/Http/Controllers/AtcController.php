<?php

namespace App\Modules\Supports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Supports\Repositories\AtcInterface;
//Repository Csupport dentro de Modulo
use Illuminate\Http\Request;

//Validación de Form request
//use App\Modules\Supports\Http\Requests\AtcRequest;

class AtcController extends Controller
{
    protected $atc;

    public function __construct(AtcInterface $atc)
    {
        $this->model = $atc;
    }

    /**************************************************************************/
    public function index()
    {
        return view('supports::atcs.index', ['identity' => 'Dashboard General Servicio al Cliente']);
    }

    /**************************************************************************/
    public function internal()
    {
        return view('supports::atcs.internal', ['identity' => 'Dashboard Servicio al Cliente - Canales Internos']);
    }

    /**************************************************************************/
    public function sale()
    {
        return view('supports::atcs.sale', ['identity' => 'Dashboard Servicio al Cliente - Ventas']);
    }

    /**************************************************************************/
    public function invoice()
    {
        return view('supports::atcs.invoice', ['identity' => 'Dashboard Servicio al Cliente - Cobranza']);
    }

    /**************************************************************************/
    public function support()
    {
        return view('supports::atcs.support', ['identity' => 'Dashboard Servicio al Cliente - Soporte']);
    }

    /**************************************************************************/
    public function operations()
    {
        return view('supports::atcs.operations', ['identity' => 'Dashboard Servicio al Cliente - Operaciones']);
    }

    /**************************************************************************/
    public function create()
    {
        return view('supports::atcs.create', ['identity' => 'Registrar SAC']);
    }

    public function createInternal()
    {
        return view('supports::atcs.create-internal', ['identity' => 'Registrar SAC - Canal Interno']);
    }

    /**************************************************************************/
    public function store(Request $request)
    {
        if (! $this->model->create($request)) {
            toastr()->warning('Error al registrar SAC');

            return redirect()->back()->withInput();
        }
        toastr()->info('Registro SAC Creado Correctamente');

        return redirect()->to('/atcs');
    }

    /**************************************************************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**************************************************************************/
    public function show($id)
    {
        return $this->model->find($id);
    }

    /**************************************************************************/
    public function update(Request $request, $id)
    {
        if (! $this->model->update($request, (int) $id)) {
            return response()->json(['success' => 'true', 'message' => 'Error al Actualizar SAC']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro SAC Actualizado Correctamente']);
    }

    /**************************************************************************/
    public function destroy(Request $request, $id)
    {
        if (! $this->model->delete($request, $id)) {
            return response()->json(['success' => 'false', 'message' => 'Error al Anulado Registro']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro SAC Anulado Correctamente']);
    }

    /**************************************************************************/
    public function datatable(Request $request)
    {
        return $this->model->datatable($request);
    }

    /**************************************************************************/
    public function totalStatus()
    {
        return $this->model->totalStatus();
    }
}
