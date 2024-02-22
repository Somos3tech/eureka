<?php

namespace App\Modules\Warehouses\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Warehouses\Repositories\Assignment\AssignmentInterface;
//Repository Assignment dentro de Modulo
use App\Modules\Warehouses\Repositories\Assignment\ReassignInterface;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    private $assignment;

    private $reassign;

    /**
     * AssignmentRepository constructor.
     *
     * @param  Assignment  $assignment
     **/
    public function __construct(AssignmentInterface $assignment, ReassignInterface $reassign)
    {
        $this->model = $assignment;
        $this->reassign = $reassign;
    }

    /*************************Guardar Registro***************************/
    public function store(Request $request)
    {
        if (! $this->model->create($request)) {
            toastr()->error('Error en la Asignación');

            return redirect()->back()->withInput();
        }
        toastr()->info('La Asignación se ha realizado Correctamente al Programador');

        return redirect()->back();
    }

    /**************************************************************************/
    public function reassign(Request $request)
    {
        if (! $this->reassign->reassign($request->all())) {
            toastr()->error('Error en la Reasignación');

            return redirect()->back()->withInput();
        }
        toastr()->info('La Reasignación se ha realizado Correctamente al Programador(Almacén)');

        return redirect()->back();
    }

    /****************************Api Select Asignación*************************/
    public function select()
    {
        return $this->model->select();
    }

    /***************************Api Select Asignación**************************/
    public function assigned(Request $request)
    {
        return $this->model->assigned($request);
    }

    /***************************Api Select Asignación**************************/
    public function assignmentUser(Request $request)
    {
        return $this->model->assignmentUser($request);
    }

    /**************Api Select Device Asignado a Reprogramador******************/
    public function assignedProgrammer(Request $request)
    {
        return $this->model->assignedProgrammer($request);
    }
}
