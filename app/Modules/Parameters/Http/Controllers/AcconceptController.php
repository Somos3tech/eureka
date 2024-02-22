<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\AcconceptRequest;
use App\Modules\Parameters\Repositories\AcconceptInterface;
use Illuminate\Http\Request;

class AcconceptController extends Controller
{
    private $acconcepts;

    /**
     * AcconceptRepository constructor.
     *
     * @param  Acconcept  $acconcepts
     **/
    public function __construct(AcconceptInterface $acconcepts)
    {
        $this->model = $acconcepts;
    }

    /********************Listado Registro Concepto Contable********************/
    public function index()
    {
        return view('parameters::acconcepts.index', ['identity' => 'Lista Categorías  Cuenta(s) Contable(s)', 'acconcept' => $this->model->manageAcconcept(false), 'acconceptall' => $this->model->manageAcconcept(true)]);
    }

    /*********************Guardar Registro Concepto Contable*******************/
    public function store(AcconceptRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al registrar Cuenta Contable']);
    }

    /******************Buscar Registro Concepto Contable***********************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /******************Actualizar Registro Concepto Contable*******************/
    public function update(AcconceptRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /****************************Eliminar Concepto Contable********************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /***********************Api Consulta Concepto Contable*********************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /**********************Api Select Concepto Contable************************/
    public function select(Request $request)
    {
        return $this->model->select($request);
    }
}
