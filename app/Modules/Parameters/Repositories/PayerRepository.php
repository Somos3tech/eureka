<?php

namespace App\Modules\Parameters\Repositories;

use App\Modules\Parameters\Models\Payer;
use App\Traits\TaskTrait;
use Auth;
use Datatable;

class PayerRepository implements PayerInterface
{
    use TaskTrait;

    protected $payer;

    /**
     * PayerRepository constructor.
     *
     * @param  Payer  $payer
     */
    public function __construct(Payer $payer)
    {
        $this->model = $payer;
    }

    /********************************Registrar*********************************/
    public function create($request)
    {
        $result = $this->model->create([
            'bank_id' => $request['bank_id'],
            'type_file' => $request['type_file'],
            'consecutive' => $request['consecutive'],
            'is_active' => $this->isActive($request),
            'user_created_id' => Auth::user()->id,
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    /***************************Buscar Información*****************************/
    public function find($id)
    {
        $data = $this->model->select('payers.id', \DB::raw("(CASE WHEN (payers.type_file='domiciliation') THEN 'Domiciliación' WHEN (payers.type_file='affiliate') THEN 'Afiliación' WHEN (payers.type_file='file') THEN 'Archivo' ELSE '---'END) AS type_file"), 'payers.consecutive', 'banks.description as bank_name')->join('banks', 'banks.id', '=', 'payers.bank_id')->where('payers.id', $id)->first();

        return \Response::json($data);
    }

    /*******************************Actualizar*********************************/
    public function update($request, $id)
    {
        $model = $this->model->findOrfail($id);
        $result = $model->update([
            'consecutive' => $request['consecutive'],
            'user_updated_id' => Auth::user()->id,
        ]);

        if ($result) {
            return true;
        }

        return false;
    }

    /****************************Get Información*******************************/
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

    /*
    /*************************Datatable Almacén********************************/
    public function datatable()
    {
        $model = $this->model->query();

        $data = $model->select('payers.id', 'banks.description as bank_name', \DB::raw("(CASE WHEN (payers.type_file='domiciliation') THEN 'Domiciliación' WHEN (payers.type_file='affiliate') THEN 'Afiliación' WHEN (payers.type_file='file') THEN 'Archivo' ELSE '---'END) AS type_file"), \DB::raw("DATE_FORMAT(payers.updated_at,'%Y-%m-%d') AS updated"), \DB::raw("LPAD(payers.consecutive,15,'0') AS consecutive"))
            ->join('banks', function ($join) {
                $join->on('banks.id', '=', 'payers.bank_id');
            })->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'payers', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**************************************************************************/
    protected function isActive($request)
    {
        if ($request->get('is_active') != null) {
            return 1;
        }

        return null;
    }

    /**************************************************************************/
    public function lastDomiciliation($request)
    {
        $payer = $this->model->select('payers.consecutive as consecutive_id')
            ->where('payers.bank_id', $request['bank_id'])
            ->where('payers.type_file', 'LIKE', 'domiciliation')
            ->first();

        if (isset($payer)) {
            return $payer->consecutive_id;
        }

        return false;
    }
}
