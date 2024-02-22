<?php

namespace App\Modules\Customers\Repositories;

use App\Events\Customer as CustomerEvent;
use App\Modules\Customers\Exports\CustomerReportExport;
use App\Modules\Customers\Models\Customer;
use App\Modules\Customers\Repositories\Customer\CustomerFactory;
use App\Modules\Preafiliations\Models\Preafiliation;
use App\Modules\Sales\Models\Contract;
use Auth;
//Reporte Cliente
use Datatable;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class CustomerRepository implements CustomerInterface
{
    protected $customer;

    protected $preafiliation;

    /**
     * CustomerRepository constructor.
     *
     * @param  Customer  $customer
     */
    public function __construct(Customer $customer, Preafiliation $preafiliation)
    {
        $this->model = $customer;
        $this->preafiliation = $preafiliation;
    }

    /***************************Registrar Cliente****************************/
    public function create($request)
    {
        $customerFactory = new CustomerFactory();
        $customer = $customerFactory->initialize($request->type_contract);
        $data = $customer->create($request);
        $result = $this->model->create($data);
        if ($result) {
            $data = $this->model->all();
            event(new CustomerEvent($data->count()));

            return $result;
        }

        return false;
    }

    /*********************Ver Información Cliente****************************/
    public function show($id)
    {
        $data = $this->model->select(
            'customers.id',
            'customers.foreign_id',
            'cp.description as company',
            'customers.company_id',
            'customers.rif',
            'customers.business_name',
            'customers.cactivity_id',
            'cactivities.description as com_activity',
            'customers.file_document',
            'customers.type_cont as type_cont',
            'customers.tax',
            'states.description as state',
            'customers.state_id',
            'cities.description as city',
            'customers.city_id',
            'customers.municipality',
            'customers.address as address',
            'customers.postal_code',
            \DB::raw('(CASE WHEN (customers.fiscal = 0 OR customers.fiscal IS NULL) THEN FALSE ELSE TRUE END) as fiscal'),
            \DB::raw("(CASE WHEN (customers.fiscal = 0 OR customers.fiscal IS NULL) THEN st.description ELSE '---' END) as state_fiscal"),
            'customers.state_fiscal_id',
            \DB::raw("(CASE WHEN (customers.fiscal = 0 OR customers.fiscal IS NULL) THEN cit.description ELSE '---' END) as city_fiscal"),
            'customers.city_fiscal_id',
            \DB::raw("(CASE WHEN (customers.fiscal = 0 OR customers.fiscal IS NULL) THEN customers.address_fiscal ELSE '---' END) as address_fiscal"),
            \DB::raw("(CASE WHEN (customers.fiscal = 0 OR customers.fiscal IS NULL) THEN customers.municipality_fiscal ELSE '---' END) as municipality_fiscal"),
            \DB::raw("(CASE WHEN (customers.fiscal = 0 OR customers.fiscal IS NULL) THEN customers.postal_code_fiscal ELSE '---' END) as postal_code_fiscal"),
            'customers.email',
            'customers.telephone',
            'customers.mobile',
            \DB::raw("CONCAT(us.name ,' ', us.last_name) as user"),
            'customers.created_at',
            \DB::raw("CONCAT(users.name ,' ', users.last_name) as userup"),
            'customers.updated_at',
            \DB::raw("(CASE WHEN (customers.comercial_register IS NULL) THEN '---' ELSE customers.comercial_register END) as comercial_register"),
            \DB::raw("(CASE WHEN (customers.date_register IS NULL) THEN '---' ELSE customers.date_register END) as date_register"),
            \DB::raw("(CASE WHEN (customers.city_register IS NULL) THEN '---' ELSE customers.city_register END) as city_register"),
            \DB::raw("(CASE WHEN (customers.number_register IS NULL) THEN '---' ELSE customers.number_register END) as number_register"),
            \DB::raw("(CASE WHEN (customers.city_register IS NULL) THEN '---' ELSE customers.city_register END) as took_register"),
            \DB::raw("(CASE WHEN (customers.clause_register IS NULL) THEN '---' ELSE customers.clause_register END) as clause_register")
        )
            ->leftjoin('companies as cp', 'cp.id', '=', 'customers.company_id')
            ->leftjoin('states', 'states.id', '=', 'customers.state_id')
            ->leftjoin('cities', 'cities.id', '=', 'customers.city_id')
            ->leftjoin('states as st', 'st.id', '=', 'customers.state_fiscal_id')
            ->leftjoin('cities as cit', 'cit.id', '=', 'customers.city_fiscal_id')
            ->leftjoin('cactivities', 'cactivities.id', '=', 'customers.cactivity_id')
            ->leftjoin('users as us', 'us.id', '=', 'customers.user_created_id')
            ->leftjoin('users as users', 'users.id', '=', 'customers.user_updated_id')
            ->where('customers.id', '=', $id)
            ->first();

        return $data;
    }

    /********************Buscar Información Cliente**************************/
    public function find($request)
    {
        if ($request->has('valid_preafiliation') && $request['valid_preafiliation'] == 1) {
            $model = $this->preafiliation->query();
            $preafiliation = $model->where('preafiliations.rif', 'LIKE', $request['data_customer'])->whereIn('preafiliations.status', ['Cargado', 'Procesado'])->first();
            if (isset($preafiliation)) {
                return true;
            } else {
                $customer = $this->model->where('customers.rif', 'LIKE', $request['data_customer'])->first();
                if (isset($customer)) {
                    return true;
                }
            }
        } else {
            $customer = $this->model->where('customers.rif', 'LIKE', $request['data_customer'])->first();
            if (isset($customer)) {
                return $customer;
            }
        }

        return false;
    }

    /*********************Actualizar Información Cliente*********************/
    public function update($request, $id)
    {
        $model = $this->model->findOrfail($id);
        $customerFactory = new CustomerFactory();
        $customer = $customerFactory->initialize($request->type_contract);
        $data = $customer->update($request);

        $result = $model->update($data);
        if ($result) {
            $data = $this->model->all();
            event(new CustomerEvent($data->count()));

            return $result;
        }

        return false;
    }

    /********************Eliminar Información Cliente************************/
    public function delete($id)
    {
        $model = $this->model->findOrfail($id);
        $model->user_deleted_id = Auth::user()->id;
        $result = $model->update();

        if ($result) {
            $result = $model->delete();

            if ($result) {
                $data = $this->model->all();
                event(new CustomerEvent($data->count()));

                return true;
            }
        }

        return false;
    }

    /**************Api Datatable - Consulta General Customer*****************/
    public function datatable($string)
    {
        $data = $this->model::select(\DB::raw('customers.id, customers.rif, customers.business_name, customers.created_at, (SELECT COUNT(*) FROM contracts as ct WHERE ct.deleted_at IS NULL AND ct.customer_id = customers.id) as tterm'))
            ->leftjoin('dcustomers as dcus', 'dcus.customer_id', '=', 'customers.id')
            ->leftjoin('contracts as cont', 'customers.id', '=', 'cont.customer_id')
            ->leftjoin('terminals as term', 'cont.terminal_id', '=', 'term.id')
            ->where('customers.id', '=', $string)
            ->OrWhere('customers.rif', 'LIKE', '%'.$string.'%')
            ->OrWhere('customers.business_name', 'LIKE', '%'.$string.'%')
            ->OrWhere('term.serial', 'LIKE', '%'.$string.'%')
            ->OrWhere('dcus.affiliate_number', 'LIKE', '%'.$string.'%')
            ->distinct('customers.rif')
            ->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                $actions = '<center>';
                if (auth()->user()->can('customers.index')) {
                    $actions .= '<a class="btn btn-sm btn-dark"  href="/customers/'.(int) $data->id.'" title="Ver Información Cliente"><i class="i i-Professor"></i></a>';
                }
                $actions .= '</center>';

                return $actions;
            })->rawColumns(['actions'])
            ->toJson();
    }

    /**************Api Datatable - Consulta General Customer*****************/
    public function datatableCheckList()
    {
        $collect = [];
        $cont = 0;

        $array = $this->model::select('customers.id', 'customers.rif', 'customers.business_name', 'customers.created_at', 'customers.file_document')->get();
        foreach ($array as $row) {
            $file_document = unserialize($row->file_document);
            if (isset($file_document)) {
                if (is_array($file_document) && array_key_exists('is_rif', $file_document)) {
                    $is_rif = true;
                } else {
                    $is_rif = false;
                }

                if (is_array($file_document) && array_key_exists('is_mercantil', $file_document)) {
                    $is_mercantil = true;
                } else {
                    $is_mercantil = false;
                }

                if (is_array($file_document) && array_key_exists('is_bank', $file_document)) {
                    $is_bank = true;
                } else {
                    $is_bank = false;
                }

                if (is_array($file_document) && array_key_exists('is_auth_bank', $file_document)) {
                    $is_auth_bank = true;
                } else {
                    $is_auth_bank = false;
                }
                if (! ($is_rif && $is_mercantil && $is_bank && $is_auth_bank)) {
                    $collect[$cont]['id'] = $row['id'];
                    $collect[$cont]['created_at'] = $row['created_at'];
                    $collect[$cont]['rif'] = $row['rif'];
                    $collect[$cont]['business_name'] = $row['business_name'];

                    $collect[$cont]['is_rif'] = $is_rif;
                    $collect[$cont]['is_mercantil'] = $is_mercantil;
                    $collect[$cont]['is_bank'] = $is_bank;
                    $collect[$cont]['is_auth_bank'] = $is_auth_bank;
                    $cont++;
                }
            } else {
                $collect[$cont]['id'] = $row['id'];
                $collect[$cont]['created_at'] = $row['created_at'];
                $collect[$cont]['rif'] = $row['rif'];
                $collect[$cont]['business_name'] = $row['business_name'];

                $collect[$cont]['is_rif'] = false;
                $collect[$cont]['is_mercantil'] = false;
                $collect[$cont]['is_bank'] = false;
                $collect[$cont]['is_auth_bank'] = false;
                $cont++;
            }
        }
        $data = Collect($collect);

        return datatables()->of($data)
            ->editColumn('is_rif', function ($data) {
                if ($data['is_rif']) {
                    return '<center>Si</center>';
                }

                return '<center>No</center>';
            })
            ->editColumn('is_mercantil', function ($data) {
                if ($data['is_mercantil']) {
                    return '<center>Si</center>';
                }

                return '<center>No</center>';
            })
            ->editColumn('is_bank', function ($data) {
                if ($data['is_bank']) {
                    return '<center>Si</center>';
                }

                return '<center>No</center>';
            })
            ->editColumn('is_auth_bank', function ($data) {
                if ($data['is_auth_bank']) {
                    return '<center>Si</center>';
                }

                return '<center>No</center>';
            })
            ->addColumn('actions', function ($data) {
                $actions = '<center>';
                if (auth()->user()->can('customers.index')) {
                    $actions .= '<a class="btn btn-sm btn-info"  href="/customers/'.(int) $data['id'].'" title="Ver Información Cliente"><i class="i i-Professor"></i></a>';
                }
                $actions .= '</center>';

                return $actions;
            })->rawColumns(['actions', 'is_rif', 'is_mercantil', 'is_bank', 'is_auth_bank'])
            ->toJson();
    }

    /**************Api Datatable - Consulta General Customer*****************/
    public function datatableCheckContract()
    {
        $data = $this->model::select('customers.id', 'ct.id as contract_id', 'customers.rif', 'customers.business_name', 'ct.created_at', 'ct.file_document')
            ->join('contracts as ct', function ($join) {
                $join->on('ct.customer_id', '=', 'customers.id');
                $join->whereNull('ct.file_document');
                $join->whereNull('ct.deleted_at');
            })->get();

        return datatables()->of($data)
            ->addColumn('actions', function ($data) {
                $actions = '<center>';
                if (auth()->user()->can('customers.index')) {
                    $actions .= '<a class="btn btn-sm btn-info"  href="/customers/'.(int) $data->id.'" title="Ver Información Cliente"><i class="i i-Professor"></i></a>';
                }
                $actions .= '</center>';

                return $actions;
            })->rawColumns(['actions'])
            ->toJson();
    }

    /******************************************************************************/
    public function report($request)
    {
        return Excel::download(new CustomerReportExport($request), 'Reporte Clientes '.date('Y-m-d').'.xlsx');
    }

    /******************Ver en archivo PDF Información Cliente**********************/
    /*public function documentPdf($id) {
      $model = $this->model->select('file_document','rif')->where('id','=',(int)$id)->first();
        $path = storage_path('customers/'). $model->file_document;
      return \Response::make(file_get_contents($path), 200, [
                                                              'Content-Type' => 'application/pdf',
                                                              'Content-Disposition' => 'inline; filename="'. $model->rif .'.pdf"'
                                                            ]);
  }*/
    /****************************************************************************/
    public function documentPdf($path_file)
    {
        $path = explode('_', $path_file);
        $path = storage_path('customers/').$path[0].'/'.$path_file;

        return \Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$path_file.'"',
        ]);
    }

    /**********Validar Archivo - Cargar en Customers en  storage*************/
    public function hasFileCustomer($request)
    {
        //verificamos arhivo si existe para cargarlo al sistema
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // generar un nombre con la extension
            $path = $request['rif'].'.'.$file->getClientOriginalExtension();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            if (file_exists(storage_path().'/customers/'.$path)) {
                $result = \Storage::disk('customers')->delete($path);
            }
            $result = \Storage::disk('customers')->put($path, \File::get($file));
        } else {
            $path = null;
        }

        return $path;
    }

    /****************************************************************************/
    public function totalCustomer()
    {
        $data = $this->model->all();

        return $data->count();
    }

    /****************************************************************************/
    public function upload($request)
    {
        if (isset($request['consec'])) {
            if ($request['type_document'] != 'contract') {
                $type_document = $request['type_document'].'_'.$request['consec'];
            } else {
                $type_document = $request['type_document'].'_'.$request['contract_id'].'_'.$request['consec'];
            }
        } else {
            if ($request['type_document'] != 'contract') {
                $type_document = $request['type_document'];
            } else {
                $type_document = $request['type_document'].'_'.$request['contract_id'];
            }
        }

        if ($request['type_document'] != 'contract') {
            $customer = $this->model->where('rif', 'LIKE', $request['rif'])->first();
        } else {
            $customer = $this->model->where('rif', 'LIKE', $request['rif'])->first();
            $contract = Contract::where('contracts.id', $request['contract_id'])->first();
        }

        if (isset($customer)) {
            $path = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // generar un nombre con la extension
                $path = $customer['rif'].'_'.$type_document.'.'.$file->getClientOriginalExtension();

                //indicamos que queremos guardar un nuevo archivo en el disco local
                if (file_exists(storage_path().'/customers/'.$customer['rif'].'/'.$path)) {
                    $result = Storage::disk('customer')->delete($customer['rif'].'/'.$path);
                }
                $result = Storage::disk('customer')->put($customer['rif'].'/'.$path, \File::get($file));
            }
        }

        $path_document = unserialize($customer->file_document);

        switch ($request['type_document']) {
            case 'rif':
                $path_document['document_rif'] = $path;
                break;
            case 'rm':
                $path_document['document_mercantil'] = $path;
                break;
            case 'bank':
                $path_document['document_bank'] = $path;
                break;
            case 'auth-bank':
                $path_document['autorization_bank'] = $path;
                break;

            case 'contract':
                $path_document['file_document'] = $path;
                break;

            default:
                return false;
                break;
        }
        if ($request['type_document'] != 'contract') {
            $customer->file_document = serialize($path_document);
            $result = $customer->save();
        } else {
            $contract->file_document = $path_document['file_document'];
            $result = $contract->save();
        }

        if ($result) {
            return $path;
        }

        return false;
    }

    /****************************************************************************/
    public function remove($request)
    {
        $rif = explode('_', $request['path']);

        $customer = $this->model->where('rif', 'LIKE', $rif[0])->first();

        if (isset($customer)) {
            //indicamos que queremos guardar un nuevo archivo en el disco local
            if (file_exists(storage_path().'/customers/'.$rif[0].'/'.$request['path'])) {
                $result = Storage::disk('customer')->delete($rif[0].'/'.$request['path']);
            }
            if ($result) {
                $path_document = unserialize($customer->file_document);

                $path = '';
                switch ($request['type_document']) {
                    case 'rif':
                        unset($path_document['document_rif']);
                        break;
                    case 'rm':
                        unset($path_document['document_mercantil']);
                        break;
                    case 'bank':
                        unset($path_document['document_bank']);
                        break;
                    case 'auth-bank':
                        unset($path_document['autorization_bank']);
                        break;

                    default:
                        return false;
                        break;
                }
                $customer->file_document = serialize($path_document);

                return $customer->update();
            }
        }

        return false;
    }

    /*******************************************************************************/
    public function checklist($request)
    {
        $customer = $this->model->where('id', (int) $request['customer_id'])->first();
        if (isset($customer)) {
            $file_document = unserialize($customer->file_document);

            if ($request['check'] == 1) {
                switch ($request['type_document']) {
                    case 'is_rif':
                        $file_document['is_rif'] = true;
                        break;
                    case 'is_mercantil':
                        $file_document['is_mercantil'] = true;
                        break;
                    case 'is_bank':
                        $file_document['is_bank'] = true;
                        break;
                    case 'is_auth_bank':
                        $file_document['is_auth_bank'] = true;
                        break;
                }
            } else {
                switch ($request['type_document']) {
                    case 'is_rif':
                        unset($file_document['is_rif']);
                        break;
                    case 'is_mercantil':
                        unset($file_document['is_mercantil']);
                        break;
                    case 'is_bank':
                        unset($file_document['is_bank']);
                        break;
                    case 'is_auth_bank':
                        unset($file_document['is_auth_bank']);
                        break;
                }
            }

            $customer->file_document = serialize($file_document);
            $result = $customer->update();
            if ($result) {
                return true;
            }
        }

        return false;
    }
}
