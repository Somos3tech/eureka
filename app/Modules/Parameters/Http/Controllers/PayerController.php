<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\PayerCreateRequest;
//Repository Payer dentro de Modulo
use App\Modules\Parameters\Http\Requests\PayerUpdateRequest;
//Validación de Form request
use App\Modules\Parameters\Repositories\PayerInterface;
use Illuminate\Http\Request;

class PayerController extends Controller
{
    private $payer;

    /**
     * PayerRepository constructor.
     *
     * @param  Payer  $payer
     **/
    public function __construct(PayerInterface $payer)
    {
        $this->model = $payer;
    }

    /***********************Listado Registro*****************************/
    public function index()
    {
        return view('parameters::payers.index', ['identity' => 'Registro No. Ordenantes x Banco']);
    }

    /***********************Guardar Registro*****************************/
    public function store(PayerCreateRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Marca']);
    }

    /***********************Buscar Registro******************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**********************Actualizar Registro***************************/
    public function update(PayerUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /***************************Eliminar*********************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /**********************Datatable Consulta Marca****************************/
    public function datatable()
    {
        return $this->model->datatable();
    }
}
