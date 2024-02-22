<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Acconcept;
use Auth;
use Datatable;

class AcconceptRepository implements AcconceptInterface
{
    protected $acconcepts;

    public function __construct(Acconcept $acconcepts)
    {
        $this->model = $acconcepts;
    }

    /***********************Registrar Cuenta Contable**************************/
    public function create($request)
    {
        $parent_id = empty($request['parent_id']) ? null : $request['parent_id'];
        $result = $this->model->create([
            'name' => $request['name'],
            'codcta' => $request['codcta'],
            'tipmon' => $request['tipmon'],
            'forma_pago' => $request['forma_pago'],
            'parent_id' => $parent_id,
            'order' => $request['order'],
            'statusc' => 1,
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /**********************Buscar Información Cuenta Contable******************/
    public function find($id)
    {
        $data = $this->model->findOrfail($id);

        return \Response::json($data);
    }

    /************************Actualizar Cuenta Contable************************/
    public function update($request, $id)
    {
        $parent_id = empty($request['parent_id']) ? null : $request['parent_id'];
        $data = [
            'name' => $request['name'],
            'codcta' => $request['codcta'],
            'tipmon' => $request['tipmon'],
            'forma_pago' => $request['forma_pago'],
            'parent_id' => $parent_id,
            'order' => $request['order'],
            'statusc' => 1,
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);

        if ($result = $model->update($data)) {
            return true;
        }

        return false;
    }

    /*********************Eliminar Soft Cuenta Contable************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;
        if ($result = $model->update()) {
            if ($result = $model->delete()) {
                return true;
            }
        }

        return false;
    }

    /************************Datatable Cuenta Contable*************************/
    public function datatable()
    {
        $data = $this->model - all();

        return datatables()->of($data = $this->model->datatable())
            ->addColumn('actions', function ($data) {
                $actions = '<center>';
                if (auth()->user()->can('acconcept.edit')) {
                    $actions .= '<button class="btn btn-sm btn-warning waves-effect waves-light" href="#" data-toggle="modal" OnClick="Acconcept(this);" data-target="#updateAcconcept" value="' . $data->id . '" title="Actualizar"><i class="ion-edit"></i></button>';
                }

                if (auth()->user()->can('acconcept.destroy')) {
                    $actions .= '&nbsp; <button class="btn btn-sm btn-danger waves-effect waves-light" href="#" data-toggle="modal" OnClick="AcconceptDel(this);" data-target="#deleteAcconcept" value="' . $data->id . '" title="Eliminar"><i class="ion-trash-a"></i></button></center>';
                }
                $actions .= '</center>';

                return $actions;
            })->rawColumns(['actions'])
            ->toJson();
    }

    /**************************Select Cuenta Contable**************************/
    public function manageAcconcept($filter)
    {
        if ($filter) {
            return $this->model->select(\DB::raw('CONCAT(acconcepts.order,"  ", acconcepts.name) as name'), 'acconcepts.id')->pluck('acconcepts.name', 'acconcepts.id');
        }

        return $this->model->select('*')->whereNull('acconcepts.parent_id')->get();
    }

    /***************************Select Cuenta Contable*************************/
    public function select($request)
    {
        $model = $this->model->query();
        //$model->select(\DB::raw("CONCAT(acconcepts.order,' - ',acconcepts.name) as description"), 'acconcepts.id');
        $model->select(\DB::raw("CONCAT(acconcepts.order,' - ',acconcepts.codcta) as description"), 'acconcepts.id');

        if ($request->get('filter') == 'collection') {
            //$model->where('acconcepts.order', 'LIKE', '1.1.1.01.01.0%')->orWhere('acconcepts.order', 'LIKE', '1.1.1.02.01.0%')->orWhere('acconcepts.order', 'LIKE', '1.1.1.03.01.0%')->orderBy('acconcepts.order', 'ASC');
            $model->whereNotNull('acconcepts.codcta')->orderBy('acconcepts.order', 'ASC');
        }

        return $model->get();
    }
}
