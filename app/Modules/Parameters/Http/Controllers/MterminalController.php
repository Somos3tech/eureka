<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\MterminalRequest;
//Repository Mterminal dentro de Modulo
use App\Modules\Parameters\Repositories\MterminalInterface;
//Validación de Form request
use Illuminate\Http\Request;

class MterminalController extends Controller
{
    private $mterminal;

    /**
     * MterminalRepository constructor.
     *
     * @param  Mterminal  $mterminal
     **/
    public function __construct(MterminalInterface $mterminal)
    {
        $this->model = $mterminal;
    }

    /*********************Listado Registro Modelo Terminal*********************/
    public function index()
    {
        return view('parameters::mterminals.index', ['identity' => 'Registro Modelo Terminal']);
    }

    /*******************Guardar Registro Modelo Terminal***********************/
    public function store(MterminalRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Modelo Terminal']);
    }

    /*********************Buscar Registro Modelo Terminal**********************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /******************Actualiar Registro Modelo Terminal**********************/
    public function update(MterminalRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /************************Eliminar Modelo Terminal**************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /**********************Datatable Modelo Terminal***************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /*************************Api Select Modelo Terminal***********************/
    public function select(Request $request)
    {
        return $this->model->select($request);
    }
}
