<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\ComissionRequest;
use App\Modules\Parameters\Repositories\ComissionInterface;
use Illuminate\Http\Request;

class ComissionController extends Controller
{
    private $comission;

    /**
     * ComissionRepository constructor.
     *
     * @param  Comission  $comission
     **/
    public function __construct(ComissionInterface $comission)
    {
        $this->model = $comission;
    }

    /***********************************Listado Registro Comision*****************************************/
    public function index()
    {
        return view('parameters::comissions.index', ['identity' => 'Condicion(es) Comercial(es) Multicomercio']);
    }

    /***********************************Guardar Registro Comision******************************************/
    public function store(ComissionRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Condición Comercial Multicomercio']);
    }

    /***********************************Buscar Registro Comision********************************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /************************************Ver Información Comision*******************************************/
    public function show($id)
    {
        return $this->model->find($id);
    }

    /***********************************Guardar Registro Comision*******************************************
    public function update(Request $request, $id){
            if($this->model->update($request, $id)) {
                return response()->json(['success'=>'true','message'=>'Registro actualizado correctamente']);
            }
        return response()->json(['success'=>'false','message'=>'Error al actualizar registro']);
    }

    /*************************************Eliminar Comision*************************************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /*********************************Api Consulta Comision**************************************************/
    public function datatable()
    {
        return datatables()->of($data = $this->model->datatable())
            ->addColumn('actions', function ($data) {
                $actions = '<center>';
                if (\Shinobi::can('comissions.show')) {
                    $actions .= '<button class="btn btn-sm btn-info waves-effect waves-light" href="#" data-toggle="modal" OnClick="ComissionDetail(this);" data-target="#detailsComission" value="'.$data->id.'" title="Detalles"><i class="ion-information-circled"></i></button>';
                }
                /*
                  if (\Shinobi::can('comissions.edit')) {
                    $actions.= '&nbsp; <button class="btn btn-sm btn-warning waves-effect waves-light" href="#" data-toggle="modal" OnClick="Comission(this);" data-target="#updateComission" value="'. $data->id .'" title="Actualizar"><i class="ion-edit"></i></button>';
                  }*/
                if (\Shinobi::can('comissions.destroy')) {
                    $actions .= '&nbsp; <button class="btn btn-sm btn-danger waves-effect waves-light" href="#" data-toggle="modal" OnClick="ComissionDel(this);" data-target="#deleteComission" value="'.$data->id.'" title="Eliminar"><i class="ion-trash-a"></i></button></center>';
                }
                $actions .= '</center>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /********************************** Api Select Comision***************************************************/
    public function select(Request $request)
    {
        return $this->model->select($request);
    }
}
