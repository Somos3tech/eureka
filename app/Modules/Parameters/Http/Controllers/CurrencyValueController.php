<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\CurrencyValueRequest;
use App\Modules\Parameters\Http\Requests\CurrencyValueUpdateRequest;
use App\Modules\Parameters\Repositories\CurrencyValueInterface;
use Illuminate\Http\Request;

class CurrencyValueController extends Controller
{
    protected $currency_value;

    /**
     * CurrencyValueRepository constructor.
     *
     * @param  CurrencyValueInterface  $currency_value
     **/
    public function __construct(CurrencyValueInterface $currency_value)
    {
        $this->model = $currency_value;
    }

    /*******************Listado Registro  Valor Divisa*************************/
    public function index()
    {
        return view('parameters::currencyvalues.index', ['identity' => 'Registro Valor Divisas']);
    }

    /**********************Guardar Registro Valor Divisa***********************/
    public function store(CurrencyValueRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Valor Divisa']);
    }

    /**********************Buscar Registro Valor Divisa************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /********************Guardar Registro Valor Divisa*************************/
    public function update(CurrencyValueUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /************************Eliminar Valor Divisa*****************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /***********************Api Datable Valor Divisa***************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /**************************************************************************/
    public function valueDycon(Request $request)
    {
        return $this->model->valueDycon($request);
    }

    /**************************************************************************/
    public function getLast()
    {
        return $this->model->getLast();
    }

    /**************************************************************************/
    public function getCurrencyValue()
    {
        return $this->model->getCurrencyValue();
    }
}
