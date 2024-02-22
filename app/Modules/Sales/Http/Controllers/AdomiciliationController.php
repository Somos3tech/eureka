<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Http\Requests\AdomiciliationRequest;
//Repository Mark dentro de Modulo
use App\Modules\Sales\Http\Requests\AdomiciliationUpdateRequest;
//Validación de Form request
use App\Modules\Sales\Repositories\AdomiciliationInterface;
use Illuminate\Http\Request;

class AdomiciliationController extends Controller
{
    private $adomiciliation;

    public function __construct(AdomiciliationInterface $adomiciliation)
    {
        $this->model = $adomiciliation;
    }

    /**************************************************************************/
    public function index()
    {
        return view('sales::adomiciliations.index', ['identity' => 'Afiliación Bancaría']);
    }

    /**************************************************************************/
    public function store(AdomiciliationRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Gestión Afiliación Bancaría Generada Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Generar Gestión Afiliación Bancaría']);
    }

    /**************************************************************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**************************************************************************/
    public function update(AdomiciliationUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Gestión Afiliación Bancaría Actualizada Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Gestión Afiliación Bancaría']);
    }

    /**************************************************************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => ' Gestión Afiliación Bancaría Anulada Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Anular  Gestión Afiliación Bancaría']);
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
            return response()->json(['success' => 'true', 'message' => ' Gestión Afiliación Bancaría fue enviada para su Gestión x Banco ']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al procesar envio de Gestión Afiliación Bancaría para su Gestión x Banco']);
    }

    /**************************************************************************/
    public function upload(Request $request)
    {
        if ($this->model->upload($request)) {
            return response()->json(['success' => 'true', 'message' => 'Carga de Resultados de Gestión Afiliación Bancaría Procesada Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Cargar Resultados Gestión Afiliación Bancaría ']);
    }

    /**************************************************************************/
    public function process($id)
    {
        if ($this->model->process($id)) {
            return response()->json(['success' => 'true', 'message' => 'Ejecución Gestión Afiliación Bancaría Iniciada Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Ejecutar Gestión Afiliación Bancaría ']);
    }
}
