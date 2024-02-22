<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\CompanyRequest;
use App\Modules\Parameters\Repositories\CompanyInterface;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private $company;

    /**
     * Company Repository constructor.
     *
     * @param  Company  $company
     **/
    public function __construct(CompanyInterface $company)
    {
        $this->model = $company;
    }

    /***********************************Listado Registro Compañia***************************************/
    public function index()
    {
        return view('parameters::companies.index', ['identity' => 'Registro Almacén']);
    }

    /***********************************Guardar Registro Compañia***************************************/
    public function store(CompanyRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Almacén']);
    }

    /***********************************Buscar Registro Compañia****************************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /***********************************Guardar Registro Compañia***************************************/
    public function update(CompanyRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /*************************************Eliminar Compañia*********************************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /******************************Api Consulta Compañia************************************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /******************************Api Select Compañia***************************************************/
    public function select(Request $request)
    {
        return $this->model->select($request);
    }

    /******************************Api Select Compañia***************************************************/
    public function zoneValid(Request $request)
    {
        return $this->model->zoneValid($request);
    }
}
