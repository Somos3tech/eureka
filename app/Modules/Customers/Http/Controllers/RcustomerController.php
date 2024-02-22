<?php

namespace App\Modules\Customers\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Customers\Http\Requests\RcustomerRequest;
//Repository Rcustomer dentro de Modulo
use App\Modules\Customers\Repositories\RcustomerInterface;
//Request
use Illuminate\Http\Request;

class RcustomerController extends Controller
{
    protected $rcustomer;

    /**
     * RcustomerRepository constructor.
     *
     * @param  Log  $log
     */
    public function __construct(RcustomerInterface $rcustomer)
    {
        $this->model = $rcustomer;
    }

    /***********************************Guardar Registro Representante Legal**************************************/
    public function store(RcustomerRequest $request)
    {
        if (! $model = $this->model->create($request)) {
            return response()->json(['success' => 'false', 'message' => 'Error al Registrar Representante Legal']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Representante Legal Creado Correctamente']);
    }

    /***********************************Buscar Registro Representante Legal**************************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /***********************************Guardar Registro Representante Legal*************************************/
    public function update(RcustomerRequest $request, $id)
    {
        $old = $this->model->find($id);
        if (! $model = $this->model->update($request, $id)) {
            return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Representante Legal']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Representante Legal Actualizado Correctamente']);
    }

    /***********************************Eliminar Representante Legal*********************************************/
    public function destroy($id)
    {
        if (! $model = $this->model->delete($id)) {
            return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Representante Legal']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Representante Legal Eliminado Correctamente']);
    }

    /******************************Api Consulta Representante Legal*********************************************/
    public function datatable(Request $request)
    {
        return $this->model->datatable($request);
    }

    /**************************************************************************/
    public function upload(Request $request)
    {
        return $this->model->upload($request);
    }

    /**************************************************************************/
    public function remove(Request $request)
    {
        return $this->model->remove($request);
    }
}
