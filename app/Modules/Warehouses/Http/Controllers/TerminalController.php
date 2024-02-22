<?php

namespace App\Modules\Warehouses\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Warehouses\Http\Requests\TerminalAssignRequest;
use App\Modules\Warehouses\Http\Requests\TerminalRequest;
use App\Modules\Warehouses\Repositories\TerminalInterface;
use Illuminate\Http\Request;

class TerminalController extends Controller
{
    protected $terminal;

    /**
     * TerminalRepository constructor.
     *
     * @param  Terminal  $terminal
     **/
    public function __construct(TerminalInterface $terminal)
    {
        $this->model = $terminal;
    }

    /**************************************************************************/
    public function index()
    {
        return view('warehouses::terminals.index', ['identity' => 'Inventario Equipos']);
    }

    /**************************************************************************/
    public function create()
    {
        return View('warehouses::terminals.upload', ['identity' => 'Cargar Equipos ', 'action' => 'create']);
    }

    /**************************************************************************/
    public function assignCompany()
    {
        return View('warehouses::terminals.upload', ['identity' => 'Asignación Equipos x Almacén', 'action' => 'assign']);
    }

    public function assign()
    {
        return View('warehouses::terminals.assign', ['identity' => 'Asignación de Equipos']);
    }

    /**************************************************************************/
    public function reassign()
    {
        return View('warehouses::terminals.reassign', ['identity' => 'Reasignación de Equipos']);
    }

    /**************************************************************************/
    public function store(TerminalRequest $request)
    {
        if (!$data = $this->model->create($request)) {
            toastr()->error('Error en la Cargar de Equipos');

            return redirect()->back()->with('message', 'Error al cargar archivo de registro de Equipos')->withInput();
        }
        toastr()->info('Registro de Equipos Procesado Correctamente');

        return View('warehouses::terminals.report-upload', ['identity' => 'Resultado Carga Equipos', 'data' => $data]);
    }

    /**************************************************************************/
    public function assignCompanyStore(TerminalAssignRequest $request)
    {
        if (!$data = $this->model->assign($request, 'A')) {
            toastr()->error('Error en la Asignación de Equipos');

            return redirect()->back()->withInput();
        }
        toastr()->info('Asignadción de Equipos procesado Correctamente');

        return View('warehouses::terminals.report-upload', ['identity' => 'Resultado Asignación Equipos', 'data' => $data]);
    }

    /**************************************************************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**************************************************************************/
    public function update(TerminalRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /**************************************************************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /**************************************************************************/
    public function restore($id)
    {
        if ($this->model->restore($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Restaurado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Restaurar Registro']);
    }

    /**************************************************************************/
    public function datatable(Request $request)
    {
        return $this->model->datatable($request);
    }

    /**************************************************************************/
    public function available(Request $request)
    {
        return $this->model->available($request);
    }

    /*************************Total Terminal(es)*******************************/
    public function totalAvailable(Request $request)
    {
        return $this->model->totalAvailable($request);
    }
    /*************************Total Terminal(es)*******************************/
    public function totalTerminals()
    {
        return $this->model->totalTerminals();
    }
}
