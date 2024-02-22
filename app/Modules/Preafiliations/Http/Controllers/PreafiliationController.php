<?php

namespace App\Modules\Preafiliations\Http\Controllers;

use App\Events\Dashboard;
use App\Http\Controllers\Controller;
use App\Modules\Preafiliations\Http\Requests\PreafiliationCreateRequest;
//Interface Preafiliation
use App\Modules\Preafiliations\Repositories\PreafiliationInterface;
use Illuminate\Http\Request;

class PreafiliationController extends Controller
{
    private $preafiliation;

    public function __construct(PreafiliationInterface $preafiliation)
    {
        $this->model = $preafiliation;
    }

    /********************************Dashboard*********************************/
    public function index()
    {
        return View('preafiliations::preafiliations.index')->with('identity', 'Dashboard Pre-Afiliación');
    }

    public function valid()
    {
        return View('preafiliations::preafiliations.valid-document')->with('identity', 'Dashboard Válidaciones Documentos Pre-Afiliación');
    }

    /**************************Registro Preafiliación**************************/
    public function create()
    {
        return View('preafiliations::preafiliations.create')->with('identity', 'Crear Registro Pre-Afiliación');
    }

    /**********************Guardar Registro Preafiliación**********************/
    public function store(PreafiliationCreateRequest $request)
    {
        $preafiliation = $this->model->create($request);
        if (! $preafiliation) {
            toastr()->warning('Error al Registrar Preafiliación');

            return redirect()->back()->withInput();
        }
        toastr()->info('Preafiliación Guardada Correctamente');

        return redirect()->to('preafiliations');
    }

    /***********************Editar Registro Preafiliación**********************/
    public function edit($id)
    {
        if (! $data = $this->model->find($id)) {
            toastr()->warning('No se encontro ningún registro Cliente en el Sistema');

            return redirect()->to('/');
        }

        return View('preafiliations::preafiliations.edit', ['identity' => 'Actualizar Información Registro PreAfiliación', 'data' => $data]);
    }

    /*******************Actualizar Registro Preafiliación**********************/
    public function update(Request $request, $id)
    {
        if (! $this->model->update($request, $id)) {
            toastr()->warning('Error al Actualizar Preafiliación');
        }
        toastr()->info('Preafiliación Actualizada Correctamente');

        return redirect()->to('preafiliations/valid');
    }

    /*******************Actualizar Registro Preafiliación**********************/
    public function updateValid(Request $request, $id)
    {
        if (! $this->model->updateValid($request, $id)) {
            toastr()->warning('Error al Procesar Preafiliación');
        }
        toastr()->info('Preafiliación Procesada Correctamente');
    }

    /**********************Ver Registro Preafiliación**************************/
    public function show($id)
    {
        return $this->model->find($id);
    }

    /**********************Datatable Preafiliación*****************************/
    public function datatable(Request $request)
    {
        return $this->model->datatable($request);
    }

    /**********************Datatable Preafiliación*****************************/
    public function validDatatable(Request $request)
    {
        return $this->model->validDatatable($request);
    }

    /**********************Eliminar Representante Legal************************/
    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return response()->json(['success' => 'true', 'message' => 'Cliente Eliminado Correctamente']);
        }

        return response()->json(['success' => 'false', 'message' => 'Error al Eliminar Cliente']);
    }

    /******************************Ver Documento PDF***************************/
    public function viewDocumentPdf(Request $request)
    {
        return $this->model->documentPdf($request);
    }

    /**************************************************************************/
    public function tempUpload(Request $request)
    {
        return $this->model->tempUpload($request);
    }

    /**************************************************************************/
    public function upload(Request $request)
    {
        return $this->model->upload($request);
    }

    /**************************************************************************/
    public function rcustomerDetail(Request $request)
    {
        return $this->model->rcustomerDetail($request);
    }

    /**************************************************************************/
    public function totalAvailable(Request $request)
    {
        return $this->model->totalAvailable($request);
    }

    /**************************************************************************/
    public function getTotal()
    {
        return $this->model->getTotal();
    }

    /**************************************************************************/
    public function remove(Request $request)
    {
        return $this->model->remove($request);
    }

    /**************************************************************************/
    public function support(Request $request, $id)
    {
        return $this->model->support($request, $id);
    }
}
