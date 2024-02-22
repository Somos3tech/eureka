<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\TermRequest;
use App\Modules\Parameters\Http\Requests\TermUpdateRequest;
use App\Modules\Parameters\Repositories\TermInterface;
use Illuminate\Http\Request;

class TermController extends Controller
{
    protected $term;

    /**
     * TermRepository constructor.
     *
     * @param  Term  $term
     **/
    public function __construct(TermInterface $term)
    {
        $this->model = $term;
    }

    /****************Listado Registro Condiciones Comerciales******************/
    public function index()
    {
        return view('parameters::terms.index', ['identity' => 'Registro Planes de Servicios']);
    }

    /****************Guardar Registro Condiciones Comerciales******************/
    public function store(TermRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Condición Comercial']);
    }

    /*****************Buscar Registro Condiciones Comerciales******************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /****************Guardar Registro Condiciones Comerciales******************/
    public function update(TermUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /***********************Ver Condiciones Comerciales************************/
    public function show($id)
    {
        return $this->model->find($id);
    }

    /********************Eliminar Condiciones Comerciales**********************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /*******************Datatable Condiciones Comerciales**********************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /********************Select Condiciones Comerciales************************/
    public function select(Request $request)
    {
        return $this->model->select($request);
    }
}
