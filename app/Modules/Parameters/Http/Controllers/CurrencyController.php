<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\CurrencyRequest;
use App\Modules\Parameters\Http\Requests\CurrencyUpdateRequest;
use App\Modules\Parameters\Repositories\CurrencyInterface;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    private $currency;

    /**
     * CurrencyRepository constructor.
     *
     * @param  Currency  $currency
     **/
    public function __construct(CurrencyInterface $currency)
    {
        $this->model = $currency;
    }

    /************************Listado Registro Divisa***************************/
    public function index()
    {
        return view('parameters::currencies.index', ['identity' => 'Registro Divisa']);
    }

    /***********************Guardar Registro Divisa****************************/
    public function store(CurrencyRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Divisa']);
    }

    /***********************Buscar Registro Divisa*****************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /************************Guardar Registro Divisa***************************/
    public function update(CurrencyUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /****************************Eliminar Divisa*******************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /*************************Api Datable Divisa*******************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /**************************Api Select Divisas******************************/
    public function select(Request $request)
    {
        return $this->model->select($request);
    }

    /**************************Api Select Divisas******************************/
    public function find(Request $request)
    {
        return $this->model->find($request['currency_id']);
    }
}
