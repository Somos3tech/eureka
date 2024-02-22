<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Http\Requests\DomiciliationRequest;
//Repository Mark dentro de Modulo
use App\Modules\Sales\Http\Requests\DomiciliationUpdateRequest;
//Validación de Form request
use App\Modules\Sales\Repositories\DomiciliationInterface;
use Illuminate\Http\Request;

class DomiciliationController extends Controller
{
    private $domiciliation;

    public function __construct(DomiciliationInterface $domiciliation)
    {
        $this->model = $domiciliation;
    }

    /**************************************************************************/
    public function index()
    {
        return view('sales::domiciliations.index', ['identity' => 'Domiciliación Bancaría']);
    }

    /**************************************************************************/
    public function store(DomiciliationRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Gestión Domiciliación Bancaría Generada Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Generar Gestión Domiciliación Bancaría']);
    }

    /**************************************************************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**************************************************************************/
    public function update(DomiciliationUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Gestión Domiciliación Bancaría Actualizada Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Gestión Domiciliación Bancaría']);
    }

    /**************************************************************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => ' Gestión Domiciliación Bancaría Anulada Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Anular  Gestión Domiciliación Bancaría']);
    }

    /**************************************************************************/
    public function datatable(Request $request)
    {
        return $this->model->datatable($request);
    }

    /**************************************************************************/
    public function download($id)
    {
        return $this->model->download($id);
    }

    /**************************************************************************/
    public function downloadResponse($id)
    {
        return $this->model->downloadResponse($id);
    }

    /**************************************************************************/
    public function send($id)
    {
        if ($this->model->send($id)) {
            return response()->json(['success' => 'true', 'message' => ' Gestión Domiciliación Bancaría fue enviada para su Gestión x Banco ']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al procesar envio de Gestión Domiciliación Bancaría para su Gestión x Banco']);
    }

    /**************************************************************************/
    public function upload(Request $request)
    {
        if ($this->model->upload($request)) {
            return response()->json(['success' => 'true', 'message' => 'Carga de Resultados de Gestión Domiciliación Bancaría Procesada Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Cargar Resultados Gestión Domiciliación Bancaría ']);
    }

    /**************************************************************************/
    public function process($id)
    {
        if ($this->model->process($id)) {
            return response()->json(['success' => 'true', 'message' => 'Ejecución Gestión Domiciliación Bancaría Iniciada Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Ejecutar Gestión Domiciliación Bancaría ']);
    }
}
