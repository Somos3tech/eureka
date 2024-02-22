<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Http\Requests\ContractCreateRequest;
use App\Modules\Sales\Repositories\ContractInterface;
//Repository Contract dentro de Modulo
use Illuminate\Http\Request;
//Request
use Illuminate\Support\Facades\Redirect;

class ContractController extends Controller
{
    private $contract;

    public function __construct(ContractInterface $contract)
    {
        $this->model = $contract;
    }

    /***********************Form Validación Contrato***************************/
    public function index()
    {
        return redirect()->to('/');
    }

    /*************Verificar - Crear Registro Contrato de Venta*****************/
    public function create()
    {
        return View('sales::contracts.create', ['identity' => 'Registro Contrato Punto de Venta']);
    }

    /*************Verificar - Crear Registro Contrato de Venta*****************/
    public function edit()
    {
        return View('sales::contracts.edit', ['identity' => 'Soporte Contrato(s)']);
    }

    /*********************Guardar Registro Contrato****************************/
    public function store(ContractCreateRequest $request)
    {
        if (! $model = $this->model->create($request)) {
            return redirect()->back()->with('message', 'Error al registrar el registro')->withInput();
        }

        return redirect()->to('/')->with('info', 'Se ha registrado Correctamente el Contrato Punto de Venta No.'.$model->id);
    }

    /*********************Actualizar Registro Contrato*************************/
    public function update(Request $request)
    {
        if (! $model = $this->model->update($request, (int) $request->id)) {
            return redirect()->back()->with('message', 'Error al Actualizar Registro')->withInput();
        }

        return redirect()->to('/')->with('info', 'Se ha Actualizado Correctamente el Contrato Punto de Venta No.'.$model->id);
    }

    /*************************Buscar Registro Contrato*************************/
    /*  public function edit($id) {
        $data = $this->model->show($id);
      return view('sales::contracts.edit',array('identity'=>'Actualizar Contrato Punto de Venta','data'=>$data));
    }
*/
    /********************Consulta Editar Registro Contrato*********************/
    public function select(Request $request)
    {
        return $this->model->select($request);
    }

    /**************************************************************************/
    public function find(Request $request)
    {
        return $this->model->find($request['contract_id']);
    }

    /**************************************************************************/
    public function contractSupport(Request $request)
    {
        return $this->model->contractSupport($request['contract_id'], $request['status']);
    }

    /*************************Ver Registro Contrato****************************/
    public function show($id)
    {
        if (! $customer = $this->model->show($id)) {
            return Redirect::to('/')->with('info', 'No se encontro ningún registro Cliente en el Sistema');
        }

        return View('customers::customers.show', ['identity' => 'Información Cliente', 'customer' => $customer]);
    }

    /************************Api Consulta de Contrato**************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /************************Api Consulta de Contrato**************************/
    public function datatableUser($id)
    {
        return $this->model->datatableUser($id);
    }

    /*****************************Ver Documento DOCX***************************/
    public function documentContract($id)
    {
        return $this->model->documentContract($id);
    }

    /**************************************************************************/
    public function getContractActive(Request $request)
    {
        return $this->model->getContractActive($request);
    }

    /**************************************************************************/
    public function getAffiliatePending(Request $request)
    {
        return $this->model->getAffiliatePending($request);
    }

    /**************************************************************************/
    public function totalContract()
    {
        return $this->model->totalContract();
    }

    /**************************************************************************/
    public function findContract(Request $request)
    {
        return $this->model->findContract($request);
    }
}
