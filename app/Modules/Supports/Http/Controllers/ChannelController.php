<?php

namespace App\Modules\Supports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Supports\Http\Requests\ChannelRequest;
use App\Modules\Supports\Repositories\ChannelInterface;

class ChannelController extends Controller
{
    protected $channel;

    public function __construct(ChannelInterface $channel)
    {
        $this->model = $channel;
    }

    /**************************************************************************/
    public function index()
    {
        return view('supports::channels.index', ['identity' => 'Canal Gestión ATC']);
    }

    /**************************************************************************/
    public function create()
    {
        return view('supports::channels.create', ['identity' => 'Registrar Canal Gestión ATC']);
    }

    /**************************************************************************/
    public function store(ChannelRequest $request)
    {
        if (! $data = $this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Error al registrar Canal Gestión ATC']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Canal Gestión ATC Creado Correctamente']);
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
    public function update(ChannelRequest $request, $id)
    {
        if (! $this->model->update($request, (int) $id)) {
            return response()->json(['success' => 'true', 'message' => 'Error al Actualizar Canal Gestión ATC']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Canal Gestión ATC Actualizado Correctamente']);
    }

    /**************************************************************************/
    public function destroy($id)
    {
        if (! $this->model->delete($id)) {
            return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Canal Gestión ATC Eliminado Correctamente']);
    }

    /**************************************************************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /**************************************************************************/
    public function select()
    {
        return $this->model->select();
    }
}
