<?php

namespace App\Modules\Customers\Repositories;

use App\Modules\Customers\Models\Dcustomer;
use App\Modules\Customers\Repositories\Dcustomer\DcustomerFactory;
use App\Traits\TaskTrait;
//Metodos de Venta - Registro No. Afiliaciòn
use Auth;

class DcustomerRepository implements DcustomerInterface
{
    use TaskTrait;

    protected $dcustomer;

    /**
     * DcustomerRepository constructor.
     *
     * @param  Dcustomer  $dcustomer
     */
    public function __construct(Dcustomer $dcustomer)
    {
        $this->model = $dcustomer;
    }

    /********************Registrar No. Afiliación Bancaria*********************/
    public function create($request)
    {
        $dcustomerFactory = new DcustomerFactory();
        $dcustomer = $dcustomerFactory->initialize($request['type_contract']);
        $data = $dcustomer->create($request);
        $result = $this->model->create($data);

        if ($result) {
            return $result;
        }

        return false;
    }

    /****************Actualizar Nro Afiliación Bancaria************************/
    public function update($request, $id)
    {
        $model = $this->model->findOrfail($id);

        if ($request['checkbox'] == 'on') {
            $multicommerce = 1;
        } else {
            $multicommerce = null;
        }

        if ($request['personal_signature'] == 'on') {
            $personal_signature = 1;
        } else {
            $personal_signature = null;
        }

        $data = [
            'multicommerce' => $multicommerce,
            'rif' => $request['rif'],
            'business_name' => $request['business_name'],
            'customer_id' => $request['customer_id'],
            'bank_id' => $request['bank_id'],
            'affiliate_number' => $request['affiliate_number'],
            'type_account' => $request['type_account'],
            'personal_signature' => $personal_signature,
            'account_number' => $request['account_number'],
            'user_updated_id' => Auth::user()->id,
        ];
        $result = $model->update($data);

        if ($result) {
            return $data = true;
        }

        return false;
    }

    /******************Eliminar Nro Afiliación Bancaria************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->affiliate_number = '0';
        $model->account_number = '0000-0000-00-0000000000';
        $model->user_deleted_id = Auth::user()->id;
        $result = $model->update();

        if ($result) {
            $result = $model->delete();
            if ($result) {
                return $data = true;
            }
        }

        return false;
    }

    /*******************Buscar No. Afiliación en Customer**********************/
    public function find($id)
    {
        $model = $this->model->query();
        $data = $model->select('dcustomers.*', 'bk.description as bank')
            ->join('banks as bk', function ($join) {
                $join->on('bk.id', '=', 'dcustomers.bank_id');
                $join->whereNull('bk.deleted_at');
            })
            ->whereIn('dcustomers.id', explode(',', $id))
            ->get();

        return \Response::json($data);
    }

    /*****************Datatable No. Afiliación en Customer*********************/
    public function datatable($request)
    {
        $data = $this->model->select(
            'dcustomers.id',
            'dcustomers.customer_id',
            \DB::raw("(CASE WHEN (dcustomers.multicommerce IS NULL) THEN 'Comercio Básico' ELSE 'Multicomercio' END) as multicommerce"),
            \DB::raw("(CASE WHEN (dcustomers.multicommerce IS NULL) THEN '----' ELSE dcustomers.rif END) as rif"),
            \DB::raw("(CASE WHEN (dcustomers.multicommerce IS NULL) THEN '----' ELSE dcustomers.business_name END) as business_name"),
            \DB::raw("(CASE WHEN (dcustomers.personal_signature=1) THEN 'Firma Personal' ELSE 'Persona Natural/RIF' END) as personal_signature"),
            'dcustomers.affiliate_number',
            'bk.description as bank',
            'dcustomers.type_account',
            'dcustomers.account_number',
            \DB::raw("(CASE WHEN (us.id != '') THEN CONCAT(us.name,' ', us.last_name) ELSE '----' END) as user_updated"),
            'dcustomers.updated_at'
        )
            ->join('banks as bk', 'bk.id', '=', 'dcustomers.bank_id')
            ->leftjoin('users as us', 'us.id', '=', 'dcustomers.user_updated_id')
            ->where('dcustomers.customer_id', '=', $request['id'])
            ->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'dcustomer', $data['id']);
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /*******************Select No. Afiliación en Customer**********************/
    public function select($request)
    {
        $model = $this->model->query();

        $model->select('dcustomers.id', \DB::raw("CONCAT(dcustomers.affiliate_number,' | ', banks.description) as description"), 'dcustomers.affiliate_number')
            ->join('banks', 'banks.id', '=', 'dcustomers.bank_id')
            ->where('dcustomers.customer_id', '=', $request['customer_id'])
            ->whereNull('dcustomers.multicommerce');
        if ($request->has('bank_id')) {
            $model->where('dcustomers.bank_id', '=', $request['bank_id']);
        }

        return \Response::json($model->get());
    }
}
