<?php

namespace App\Modules\Customers\Repositories;

use App\Modules\Customers\Models\Rcustomer;
use App\Traits\TaskTrait;
use Auth;
use Storage;

class RcustomerRepository implements RcustomerInterface
{
    use TaskTrait;

    protected $rcustomer;

    /**
     * RcustomerRepository constructor.
     *
     * @param  Rcustomer  $rcustomer
     */
    public function __construct(Rcustomer $rcustomer)
    {
        $this->model = $rcustomer;
    }

    /********************Registrar Representante Legal*************************/
    public function create($request)
    {
        $result = $this->model->create([
            'customer_id' => $request['customer_id'],
            'document' => $request['ident_number'],
            'first_name' => $request['first_name'],
            'jobtitle' => $request['jobtitle'],
            'email' => $request['email'],
            'telephone' => $request['telephone'],
            'user_created_id' => Auth::user()->id,
            'user_updated_id' => Auth::user()->id,
        ]);
        if ($result) {
            return $result;
        }

        return false;
    }

    /***********************Buscar Representante Legal*************************/
    public function find($id)
    {
        $model = $this->model->query();
        $data = $model->where('rcustomers.id', $id)->get();

        return \Response::json($data);
    }

    /**********************Actualizar Representante Legal**********************/
    public function update($request, $id)
    {
        $model = $this->model->findOrfail($id);
        $data = [
            'customer_id' => $request['customer_id'],
            'document' => $request['ident_number'],
            'first_name' => $request['first_name'],
            'jobtitle' => $request['jobtitle'],
            'email' => $request['email'],
            'telephone' => $request['telephone'],
            'user_updated_id' => Auth::user()->id,
        ];

        $result = $model->update($data);

        if ($result) {
            return $model;
        }

        return false;
    }

    /************************Eliminar Representante Legal**********************/
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

    /******************Api Datatable - Consulta Representante Legal************/
    public function datatable($request)
    {
        $data = $this->model::select('rcustomers.id', 'rcustomers.document as document_number', 'rcustomers.first_name', 'rcustomers.jobtitle', 'rcustomers.email', 'rcustomers.telephone', 'rcustomers.file_document', \DB::raw("(CASE WHEN (us.id != '') THEN CONCAT(us.name,' ', us.last_name) ELSE '----' END) as user_updated"), 'rcustomers.updated_at')
            ->leftjoin('users as us', 'us.id', '=', 'rcustomers.user_updated_id')
            ->where('rcustomers.customer_id', '=', $request['id'])
            ->get();

        return datatables()->of($data)
            ->addColumn('document', function ($data) {
                $file_document = '<button href="#" class="btn btn-sm btn-warning" data-toggle="modal" OnClick="documentRcustomer(this);" value="'.$data->id.'" data-target="#uploadRcustomer" style="color:white;" title="Cargar o Actualizar Documento"><i class="i-Data-Upload"></i></button>';
                if ($data->file_document != null) {
                    $file_document .= '&nbsp;<button href="#" class="btn btn-sm btn-danger" data-toggle="modal" OnClick="documentFile(this);" value="'.$data->file_document.'" data-target="#viewDocument"  title="Ver Documento Representante"><i class="i-Cloud"></i></button>';
                }

                return $file_document;
            })
            ->addColumn('actions', function ($data) {
                return $this->buttonActionS(true, true, 'rcustomer', $data['id']);
            })
            ->rawColumns(['document', 'actions'])
            ->toJson();
    }

    /****************************************************************************/
    public function upload($request)
    {
        $rcustomer = $this->model->where('rcustomers.id', $request['rcustomer_id'])->first();

        if (isset($rcustomer)) {
            $path = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // generar un nombre con la extension
                $path = $request['rif'].'_rcustomer_'.$rcustomer['document'].'.'.$file->getClientOriginalExtension();

                //indicamos que queremos guardar un nuevo archivo en el disco local
                if (file_exists(storage_path().'/customers/'.$request['rif'].'/'.$path)) {
                    $result = Storage::disk('customer')->delete($request['rif'].'/'.$path);
                }
                $result = Storage::disk('customer')->put($request['rif'].'/'.$path, \File::get($file));
            }
        }

        $rcustomer->file_document = $path;
        $result = $rcustomer->save();

        if ($result) {
            return $path;
        }

        return false;
    }

    /****************************************************************************/
    public function remove($request)
    {
        $rcustomer = $this->model->where('rcustomers.id', $request['rcustomer_id'])->first();
        if (isset($rcustomer)) {
            //indicamos que queremos guardar un nuevo archivo en el disco local
            if (file_exists(storage_path().'/customers/'.$request['rif'].'/'.$rcustomer->file_document)) {
                $result = Storage::disk('customer')->delete($request['rif'].'/'.$rcustomer->file_document);
            }
            if ($result) {
                $rcustomer->file_document = null;
                $result = $rcustomer->update();
                if (isset($result)) {
                    return true;
                }
            }
        }

        return false;
    }
}
