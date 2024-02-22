<?php

namespace App\Modules\Supports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Supports\Http\Requests\ManagementtypeRequest;
use App\Modules\Supports\Http\Requests\ManagementtypeUpdateRequest;
use App\Modules\Supports\Repositories\ManagementtypeInterface;
use Illuminate\Http\Request;

class ManagementtypeController extends Controller
{
    protected $managementtype;

    public function __construct(ManagementtypeInterface $managementtype)
    {
        $this->model = $managementtype;
    }

    /**************************************************************************/
    public function index()
    {
        return view('supports::managementtypes.index', ['identity' => ' Tipo Gestión ATC']);
    }

    /**************************************************************************/
    public function create()
    {
        return view('supports::managementtypes.create', ['identity' => 'Registrar Tipo Gestión ATC']);
    }

    /**************************************************************************/
    public function store(ManagementtypeRequest $request)
    {
        if (! $data = $this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Error al registrar Tipo Gestión ATC']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro  Tipo Gestión ATC Creado Correctamente']);
    }

    /**************************************************************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**************************************************************************/
    public function show($id)
    {
        return $this->model->find($id);
    }

    /**************************************************************************/
    public function update(ManagementtypeUpdateRequest $request, $id)
    {
        if (! $this->model->update($request, (int) $id)) {
            return response()->json(['success' => 'true', 'message' => 'Error al Actualizar Tipo Gestión ATC']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Tipo Gestión ATC Actualizado Correctamente']);
    }

    /**************************************************************************/
    public function destroy($id)
    {
        if (! $this->model->delete($id)) {
            return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro  Tipo Gestión ATC Eliminado Correctamente']);
    }

    /**************************************************************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /**************************************************************************/
    public function select(Request $request)
    {
        return $this->model->select($request);
    }
}
