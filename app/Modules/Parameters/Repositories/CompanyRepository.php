<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Company;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class CompanyRepository implements CompanyInterface
{
    use TaskTrait;

    private $company;

    /**
     * Company Repository constructor.
     *
     * @param  Company  $company
     **/
    public function __construct(Company $company)
    {
        $this->model = $company;
    }

    /*************************Registrar Almacén******************************/
    public function create($request)
    {
        $result = $this->model->create([
            'business_id' => $request['business_id'],
            'description' => $request['description'],
            'typecompany_id' => $request['typecompany_id'],
            'is_wholesaler' => $this->wholesaler($request),
            'user_created_id' => \Auth::user()->id,
        ]);
        if ($result) {
            return $result;
        }

        return false;
    }

    /********************Buscar Información Almacén**************************/
    public function find($id)
    {
        return \Response::json($this->model->findOrfail($id));
    }

    /***********************Actualizar Almacén*******************************/
    public function update($request, $id)
    {
        $data = [
            'business_id' => $request['business_id'],
            'description' => $request['description'],
            'typecompany_id' => $request['typecompany_id'],
            'is_wholesaler' => $this->wholesaler($request),
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);
        if ($result) {
            return $result;
        }

        return false;
    }

    /************************Eliminar Almacén********************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = \Auth::user()->id;

        if ($result = $model->update()) {
            if ($result = $model->delete()) {
                return true;
            }
        }

        return false;
    }

    /*************************Datatable Almacén********************************/
    public function datatable()
    {
        $model = $this->model->query();

        $data = $model->select('companies.id', 'companies.description', \DB::raw(" (CASE WHEN (bs.name IS NULL) THEN '----' ELSE bs.name END) as name_business"), \DB::raw(" (CASE WHEN (tc.description IS NULL) THEN '----' ELSE tc.description END) as name_typecompany"), \DB::raw(" (CASE WHEN (companies.is_wholesaler IS NULL) THEN 'No' WHEN (companies.is_wholesaler = 0) THEN 'No' ELSE 'Si' END) as wholesaler"))
            ->leftjoin('business as bs', function ($join) {
                $join->on('bs.id', '=', 'companies.business_id');
            })
            ->leftjoin('typecompanies as tc', function ($join) {
                $join->on('tc.id', '=', 'companies.typecompany_id');
            })->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'company', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /***************************Api Almacén************************************/
    public function select($request)
    {
        $model = $this->model->query();
        $model->select('id', 'description');

        if (isset($request['except'])) {
            $model->where('id', '!=', '1');
        }

        return $model->orderBy('description', 'ASC')->get();
    }

    /*************************Api Almacén Valid********************************/
    public function zoneValid($request)
    {
        $model = $this->model->query();
        $model->select('id', 'description');

        if (Auth::user()->company_id != '' && (($request->get('slug') == 'sales') || ($request->get('slug') == 'assistant'))) {
            $model->where('id', '=', Auth::user()->company_id);
        }

        if ($request->get('wholesaler') == 0) {
            $model->where('is_wholesaler', '=', 0)->orWhereNull('is_wholesaler');
        }

        return $model->orderBy('description', 'ASC')->get();
    }

    /**************************************************************************/
    protected function wholesaler($request)
    {
        if ($request->get('is_wholesaler') != null) {
            return 1;
        }

        return 0;
    }
}
