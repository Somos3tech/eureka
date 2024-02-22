<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\PmethodRequest;
//Repository Pmethod dentro de Modulo
use App\Modules\Parameters\Http\Requests\PmethodUpdateRequest;
//Validación de Form request
use App\Modules\Parameters\Repositories\PmethodInterface;
use Illuminate\Http\Request;

class PmethodController extends Controller
{
    private $pmethod;

    public function __construct(PmethodInterface $pmethod)
    {
        $this->model = $pmethod;
    }

    /***********************Listado Registro Método Pago*****************************/
    public function index()
    {
        return view('parameters::pmethods.index', ['identity' => 'Registro Método(s) de Pago(s)']);
    }

    /***********************Guardar Registro Método Pago*****************************/
    public function store(PmethodRequest $request)
    {
        if ($data = $this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Método de Pago']);
    }

    /***********************Buscar Registro Método Pago******************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /***********************Ver Registro Método Pago******************************/
    public function show($id)
    {
        return $this->model->find($id);
    }

    /**********************Actualizar Registro Método Pago***************************/
    public function update(PmethodUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /***************************Eliminar Método Pago*********************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /**********************Datatable Consulta Método Pago****************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /*************************Api Select Método Pago*********************************/
    public function select()
    {
        return $this->model->select();
    }
}
