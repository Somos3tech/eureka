<?php

namespace App\Modules\Warehouses\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Warehouses\Http\Requests\SimcardAssignRequest;
use App\Modules\Warehouses\Http\Requests\SimcardRequest;
use App\Modules\Warehouses\Repositories\SimcardInterface;
use Illuminate\Http\Request;

class SimcardController extends Controller
{
    protected $simcard;

    /**
     * SimcardRepository constructor.
     *
     * @param  Simcard  $simcard
     **/
    public function __construct(SimcardInterface $simcard)
    {
        $this->model = $simcard;
    }

    /************************Listado Registro Simcard(s)***********************/
    public function index()
    {
        return view('warehouses::simcards.index', ['identity' => 'Inventario Simcard´s']);
    }

    /**************************Registrar Simcard(s)****************************/
    public function create()
    {
        return View('warehouses::simcards.upload', ['identity' => 'Registrar Simcard´s', 'action' => 'create']);
    }

    /**************************************************************************/
    public function assignCompany()
    {
        return View('warehouses::simcards.upload', ['identity' => 'Asignación Simcard´s x Almacén', 'action' => 'assign']);
    }

    /*************************Registro Simcard(s)******************************/
    public function assign()
    {
        return View('warehouses::simcards.assign', ['identity' => 'Asignar Simcard`s', 'action' => 'assign']);
    }

    /**************************************************************************/
    public function reassign()
    {
        return View('warehouses::simcards.reassign', ['identity' => 'Reasignación de Simcard´s']);
    }

    /**********************Guardar Registro Simcard(s)*************************/
    public function store(SimcardRequest $request)
    {
        if (! $data = $this->model->create($request)) {
            toastr()->error('Error en la Cargar de Simcard`s');

            return redirect()->back()->withInput();
        }
        toastr()->info('Registro de Simcard`s Procesado Correctamente');

        return View('warehouses::simcards.report-upload', ['identity' => 'Resultado Carga Simcard', 'data' => $data]);
    }

    /**********************Guardar Registro Simcard(s)*************************/
    public function assignZoneStore(SimcardAssignRequest $request)
    {
        if (! $data = $this->model->assign($request, 'A')) {
            toastr()->error('Error en la Asignación de Simcard`s');

            return redirect()->back()->withInput();
        }
        toastr()->info('Asginación de Simcard`s Procesado Correctamente');

        return View('warehouses::simcards.report-upload', ['identity' => 'Resultado Asignación Simcard', 'data' => $data]);
    }

    /**********************Buscar Registro Simcard(s)**************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /****************************Guardar Registro Simcard(s)*******************/
    public function update(SimcardRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /*****************************Eliminar Simcard(s***************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /**************************Restaurar Simcard(es)***************************/
    public function restore($id)
    {
        if ($this->model->restore($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Restaurado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Restaurar Registro']);
    }

    /**********************Api Consulta Simcard(s)*****************************/
    public function datatable(Request $request)
    {
        return $this->model->datatable($request);
    }

    /*************************Disponible Simcard(s)****************************/
    public function available(Request $request)
    {
        return $this->model->available($request);
    }
}
