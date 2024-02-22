<?php

namespace App\Modules\Customers\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Customers\Http\Requests\CustomerCreateRequest;
//Interface Customer
use App\Modules\Customers\Http\Requests\CustomerUpdateRequest;
use App\Modules\Customers\Repositories\CustomerInterface;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customer;

    public function __construct(CustomerInterface $customer)
    {
        $this->model = $customer;
    }

    /**********************************Cliente*********************************/
    public function index()
    {
        return redirect()->to('/');
    }

    /********************Verificar - Crear Registro Customer*******************/
    public function create()
    {
        return View('customers::customers.create')->with('identity', 'Crear Registro Cliente');
    }

    /*************************Guardar Registro Customer************************/
    public function store(CustomerCreateRequest $request)
    {
        if (!$model = $this->model->create($request)) {
            toastr()->error('Error al Registrar Cliente');

            return redirect()->back()->withInput();
        }
        toastr()->info('Se ha registrado correctamente la información ingresada del Cliente - No. Código: ' . $model->id);

        return redirect()->to('customers/' . $model->id);
    }

    /***********************Consulta Editar Registro Customer******************/
    public function edit($id)
    {
        if (!$data = $this->model->show($id)) {
            toastr()->error('No se encontro ningún registro Cliente en el Sistema');

            return redirect()->to('/');
        }

        return View('customers::customers.edit', ['identity' => 'Actualizar Información Cliente', 'data' => $data]);
    }

    /***********************Actualizar Registro Customer***********************/
    public function update(CustomerUpdateRequest $request, $id)
    {
        if (!$model = $this->model->update($request, $id)) {
            toastr()->error('Error al actualizar información del Cliente');

            return redirect()->back()->withInput();
        }
        toastr()->info('Se ha actualizado correctamente la información del Cliente');

        return redirect()->to('customers/' . $id);
    }

    /***************************Ver Registro Customer**************************/
    public function show($id)
    {
        if (!$data = $this->model->show($id)) {
            toastr()->error('No se encontro ningún registro Cliente en el Sistema');

            return redirect()->to('/');
        }

        return View('customers::customers.show', ['identity' => 'Información Cliente', 'customer' => $data]);
    }

    /**************************Form Consulta de Cliente************************/
    public function search(Request $request)
    {
        return View('customers::customers.index', ['identity' => 'Consulta Registro Cliente', 'string' => $request['string']]);
    }

    /**************************Form Consulta de Cliente************************/
    public function validCheckList()
    {
        return View('customers::customers.checklist', ['identity' => 'Clientes - Válidación Documentación Fisica']);
    }

    /**************************Form Consulta de Cliente************************/
    public function validCheckContract()
    {
        return View('customers::customers.checkcontract', ['identity' => 'Clientes - Válidación Formalización Contrato']);
    }

    /******************************Form Consulta de Cliente********************/
    public function find(Request $request)
    {
        return \Response::json($this->model->find($request));
    }

    /**********************Eliminar Representante Legal************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Cliente Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Cliente']);
    }

    /**********************Api Consulta de Cliente*****************************/
    public function datatable(Request $request)
    { //Datatable
        return  $this->model->datatable($request['string']);
    }

    /**********************Api Consulta de Cliente*****************************/
    public function datatableCheckList()
    { //Datatable
        return  $this->model->datatableCheckList();
    }

    /**********************Api Consulta de Cliente*****************************/
    public function datatableCheckContract()
    { //Datatable
        return  $this->model->datatableCheckContract();
    }

    /******************************Ver Documento PDF***************************/
    public function viewDocumentPdf($path_file)
    {
        return $this->model->documentPdf($path_file);
    }

    /**************************************************************************/
    public function totalCustomer()
    {
        return $this->model->totalCustomer();
    }

    /**************************************************************************/
    public function documentContract($id)
    {
        return $this->model->documentContract($id);
    }

    /**************************************************************************/
    public function upload(Request $request)
    {
        return $this->model->upload($request);
    }

    /**************************************************************************/
    public function checklist(Request $request)
    {
        return $this->model->checklist($request);
    }

    /**************************************************************************/
    public function remove(Request $request)
    {
        return $this->model->remove($request);
    }
}
