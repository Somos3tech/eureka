<?php

namespace App\Modules\Customers\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Customers\Http\Requests\DcustomerRequest;
use App\Modules\Customers\Http\Requests\DcustomerUpdateRequest;
//Request
use App\Modules\Customers\Repositories\DcustomerInterface;
use Illuminate\Http\Request;

class DcustomerController extends Controller
{
    protected $dcustomer;

    /**
     * LogRepository constructor.
     *
     * @param  Dcustomer  $dcustomer
     */
    public function __construct(DcustomerInterface $dcustomer)
    {
        $this->model = $dcustomer;
    }

    /***********************************Guardar Registro Representante Legal*********************************************/
    public function store(DcustomerRequest $request)
    {
        $data = [];
        if (! $model = $this->model->create($request)) {
            return response()->json(['success' => 'false', 'message' => 'Error al Registrar No. Afiliación Bancaria']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro No. Afiliación Bancaria Creado Correctamente']);
    }

    /*************************************************Edit***************************************************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /*******************************************************************************************************************/
    public function update(DcustomerUpdateRequest $request, $id)
    {
        if (! $model = $this->model->update($request, $id)) {
            return response()->json(['success' => 'false', 'message' => 'Error al Actualizar No. Afiliación Bancaria']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro No. Afiliación Bancaria Actualizado Correctamente']);
    }

    /*****************************************Eliminar Representante Legal*********************************************/
    public function destroy($id)
    {
        if (! $model = $this->model->delete($id)) {
            return response()->json(['success' => 'false', 'message' => 'Error al Eliminar No. Afiliación Bancaria']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro No. Afiliación Bancaria Eliminado Correctamente']);
    }

    /*****************************************Api Consulta Representante Legal***************************************/
    public function datatable(Request $request)
    {
        return $this->model->datatable($request);
    }

    /***********************************************Select*********************************************************/
    public function find(Request $request)
    {
        return $this->model->find($request['affiliate_number']);
    }

    /***********************************************Select*********************************************************/
    public function select(Request $request)
    {
        return $this->model->select($request);
    }
}
