<?php

namespace App\Modules\Supports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Supports\Http\Requests\CsupportRequest;
//Repository Csupport dentro de Modulo
use App\Modules\Supports\Http\Requests\CsupportUpdateRequest;
//Validación de Form request
use App\Modules\Supports\Repositories\CsupportInterface;
use Illuminate\Http\Request;

class CsupportController extends Controller
{
    private $csupport;

    /**
     * CsupportRepository constructor.
     *
     * @param  Csupport  $csupport
     **/
    public function __construct(CsupportInterface $csupport)
    {
        $this->model = $csupport;
    }

    /***********************Listado Registro Soporte Administrativo*****************************/
    public function index()
    {
        return view('supports::csupports.index', ['identity' => 'Soporte Administrativo']);
    }

    /********************Crear Registro Soporte Administrativo*****************/
    public function create()
    {
        return view('supports::csupports.create', ['identity' => 'Registrar Soporte Administrativo']);
    }

    /******************Guardar Registro Soporte Administrativo*****************/
    public function store(CsupportRequest $request)
    {
        if (!$data = $this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Error al registrar Soporte Administrativo']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Soporte Administrativo Creado Correctamente']);
    }

    /********************Buscar Registro Soporte Administrativo****************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**************************************************************************/
    public function show($id)
    {
        return $this->model->find($id);
    }

    /**********************Actualizar Registro Soporte Administrativo***************************/
    public function update(CsupportUpdateRequest $request, $id)
    {
        if (!$this->model->update($request, (int) $id)) {
            return response()->json(['success' => 'true', 'message' => 'Error al Actualizar Registro Soporte Administrativo']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Soporte Administrativo Actualizado Correctamente']);
    }

    /***************************Eliminar Soporte Administrativo*********************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Soporte Administrativo Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error Soporte Administrativo al Eliminar Registro']);
    }

    /**********************Datatable Consulta Soporte Administrativo****************************/
    public function datatable()
    {
        return $this->model->datatable();
    }
}
