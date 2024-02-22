<?php

namespace App\Modules\Parameters\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Parameters\Http\Requests\BankRequest;
use App\Modules\Parameters\Http\Requests\BankUpdateRequest;
use App\Modules\Parameters\Repositories\BankInterface;
use Illuminate\Http\Request;

class BankController extends Controller
{
    private $bank;

    /**
     * BankRepository constructor.
     *
     * @param  Bank  $bank
     **/
    public function __construct(BankInterface $bank)
    {
        $this->model = $bank;
    }

    /************************Listado Registro Banco(s)*************************/
    public function index()
    {
        return view('parameters::banks.index', ['identity' => 'Registro Banco']);
    }

    /**************************Guardar Registro Banco**************************/
    public function store(BankRequest $request)
    {
        if ($this->model->create($request)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Creado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Registrar Banco']);
    }

    /**************************Buscar Registro Banco***************************/
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /************************Actualizar Registro Banco*************************/
    public function update(BankUpdateRequest $request, $id)
    {
        if ($this->model->update($request, $id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Actualizado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Registro']);
    }

    /*****************************Eliminar Banco*******************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Registro Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Registro']);
    }

    /************************Datatable Consulta Banco**************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /************************Api Select Banco**********************************/
    public function select(Request $request)
    {
        return $this->model->select($request);
    }

    /********************Api Select Bankcode Banco*****************************/
    public function bankCode(Request $request)
    {
        return $this->model->bankCode($request->get('bank_id'));
    }
}
