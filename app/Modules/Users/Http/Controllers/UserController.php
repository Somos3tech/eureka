<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Users\Http\Requests\UserCreateRequest;
use App\Modules\Users\Http\Requests\UserUpdateRequest;
use App\Modules\Users\Repositories\User\UserInterface;
use Caffeinated\Shinobi\Models\Role;
//Repository User dentro de Modulo
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;

    /**
     * UserRepository constructor.
     *
     * @param  User  $user
     **/
    public function __construct(UserInterface $user)
    {
        $this->model = $user;
    }

    /***********************Listado Registro Usuarios(s)***********************/
    public function index()
    {
        return view('users::users.index', ['identity' => 'Registro Usuario(s)']);
    }

    /**************************************************************************/
    public function create()
    {
        return view('users::users.create', ['identity' => 'Registrar Usuario']);
    }

    /************************Guardar Registro Usuario**************************/
    public function store(UserCreateRequest $request)
    {
        $user = $this->model->create($request);
        if (! $user) {
            toastr()->warning('Error al Registrar Usuario');

            return redirect()->back()->withInput();
        }
        toastr()->info('Registro Usuario Guardado Correctamente');

        return redirect()->to('users');
    }

    /*************************Buscar Registro Usuario**************************/
    public function edit($id)
    {
        $data = $this->model->find($id);

        return view('users::users.edit', ['identity' => 'Actualizar Usuario', 'data' => $data]);
    }

    /***********************Guardar Registro Usuario***************************/
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->model->update($request, $id);
        if (! $user) {
            toastr()->warning('Error al Actualizar Registro Usuario');

            return redirect()->back()->withInput();
        }
        toastr()->info('Registro Usuario Actualizado Correctamente');

        return redirect()->to('users');
    }

    /*************************Ver Registro Usuario*****************************/
    public function show($id)
    {
        return $this->model->find($id);
    }

    /***************************Suspender Usuario******************************/
    public function destroy($id)
    {
        $user = $this->model->delete($id);
        if (! $user) {
            return response()->json(['success' => 'false', 'message' => 'Error al Suspender Registro Usuario']);
        }

        return response()->json(['success' => 'true', 'message' => 'Registro Usuario Suspendido Correctamente']);
    }

    /***************************Datatable Usuario******************************/
    public function datatable()
    {
        return $this->model->datatable();
    }

    /**************************Select Consulta Role****************************/
    public function select(Request $request)
    {
        return $this->model->select($request->has('slug') ? $request->get('slug') : null, $request->has('user_id') ? $request->get('user_id') : null, $request->has('company_id') ? $request->get('company_id') : null);
    }

    /***************************Consulta Role**********************************/
    public function assignment(Request $request)
    {
        return $this->model->assignment($request);
    }

    /***************************Perfil Usuario*********************************/
    public function profile()
    {
        return view('users::users.profile', ['identity' => $identity = 'Perfíl Usuario', 'data' => $data = $this->model->find(\Auth::user()->id)]);
    }

    /**********************Cambio Conatraseña Usuario**************************/
    public function changePassword(Request $request)
    {
        $password = $this->model->changePassword($request->get('password'));
        if (! $password) {
            return response()->json(['success' => 'false', 'message' => 'Error al Actualizar Contraseña']);
        }

        return response()->json(['success' => 'true', 'message' => 'Contraseña Actualizada Correctamente']);
    }
}
