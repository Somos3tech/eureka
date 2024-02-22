<?php

namespace App\Modules\Supports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Supports\Http\Requests\MtypeitemRequest;
use App\Modules\Supports\Repositories\MtypeitemInterface;
use Illuminate\Http\Request;

class MtypeitemController extends Controller
{
    protected $mtypeitem;

    public function __construct(MtypeitemInterface $mtypeitem)
    {
        $this->model = $mtypeitem;
    }

    /**************************************************************************/
    public function index()
    {
        return view('supports::mtypeitems.index', ['identity' => 'Item Gestión ATC']);
    }

    /**************************************************************************/
    public function create()
    {
        return view('supports::mtypeitems.create', ['identity' => 'Registrar Item Gestión ATC']);
    }

    /**************************************************************************/
    public function store(MtypeitemRequest $request)
    {
        if (! $data = $this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Error al registrar Item Gestión ATC']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Item Gestión ATC Creado Correctamente']);
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
    public function update(MtypeitemRequest $request, $id)
    {
        if (! $this->model->update($request, (int) $id)) {
            return response()->json(['success' => 'true', 'message' => 'Error al Actualizar Item Gestión ATC']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Item Gestión ATC Actualizado Correctamente']);
    }

    /**************************************************************************/
    public function destroy($id)
    {
        if (! $this->model->delete($id)) {
            return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Item Gestión ATC Eliminado Correctamente']);
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
