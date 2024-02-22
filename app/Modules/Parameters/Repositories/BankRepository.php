<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Bank;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class BankRepository implements BankInterface
{
    use TaskTrait;

    protected $bank;

    /**
     * BankRepository constructor.
     *
     * @param  Bank  $Bank
     */
    public function __construct(Bank $bank)
    {
        $this->model = $bank;
    }

    /******************************Registrar Banco****************************/
    public function create($request)
    {
        $result = $this->model->create([
            'description' => $request['description'],
            'rif' => $request['rif'],
            'address' => $request['address'],
            'bank_code' => $request['bank_code'],
            'is_register' => $this->isRegister($request),
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /******************************Información Banco**************************/
    public function find($id)
    {
        return \Response::json($this->model->where('id', '=', $id)->first());
    }

    /******************************Actualizar Banco***************************/
    public function update($request, $id)
    {
        $data = [
            'description' => $request['description'],
            'rif' => $request['rif'],
            'address' => $request['address'],
            'bank_code' => $request['bank_code'],
            'is_register' => $this->isRegister($request),
            'user_updated_id' => Auth::user()->id,
        ];

        $model = $this->model->findOrfail($id);
        $result = $model->update($data);

        if ($result) {
            return true;
        }

        return false;
    }

    /******************************Eliminar Banco*****************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;
        $result = $model->update();

        if ($result) {
            $result = $model->delete();
            if ($result) {
                return true;
            }
        }

        return false;
    }

    /******************************Datatable Banco******************************/
    public function datatable()
    {
        $model = $this->model->query();
        $data = $model->select('id', 'rif', 'description', 'address', 'bank_code', \DB::raw("(CASE WHEN (banks.is_register IS NULL OR banks.is_register=0) THEN 'No' ELSE 'Si' END) AS is_register"))->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'banks', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /******************************Select Banco*********************************/
    public function select($request)
    {
        $model = $this->model->select('id', 'description');

        if ($request->has('is_register')) {
            $model->where('is_register', '=', '1');
        }

        return $model->get();
    }

    /******************+Consultar Codigo Banco***********************************/
    public function bankCode($bank_id)
    {
        $data = Bank::select('bank_code')->where('id', '=', $bank_id)->first();
        if ($data) {
            return $data;
        }

        return false;
    }

    /**************************************************************************/
    protected function isRegister($request)
    {
        if ($request->get('is_register') != null) {
            return 1;
        }

        return 0;
    }
}
