<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\ConsultantRequest;
use App\Modules\Parameters\Http\Requests\ConsultantUpdateRequest;
use App\Modules\Parameters\Repositories\ConsultantInterface;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    private $consultant;

    /**
     * ConsultantRepository constructor.
     *
     * @param  Consultant  $consultant
     **/
    public function __construct(ConsultantInterface $consultant)
    {
        $this->model = $consultant;
    }

    /***************Listado Registro Asesor de Ventas Externo******************/
    public function index()
    {
        return view('parameters::consultants.index', ['identity' => 'Registro Aliado Comercial']);
    }

    /***************Guardar Registro Asesor de Ventas Externo******************/
    public function store(ConsultantRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Aliado Comercial']);
    }

    /***************Buscar Registro Asesor de Ventas Externo*******************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /*************Actualizar Registro Asesor de Ventas Externo*****************/
    public function update(ConsultantUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /******************Eliminar Asesor de Ventas Externo***********************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /****************Api Datatable Asesor de Ventas Externo********************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /***************Api Select Asesor de Ventas Externo************************/
    public function select(Request $request)
    {
        return $this->model->select2($request['user_id']);
    }
}
