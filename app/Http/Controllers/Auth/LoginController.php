<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        /**
         * ! Jorge Thomas
         * * Se agrega variable de "remember", con el fin de que la funcionalidad de mantener sesión abierta, este disponible
         **/
        $remember = $request->has('remember') ? true : false;

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password'], 'status' => 'activo'], $remember)) {
            toastr()->info('Bienvenido a Eureka,  Sr(a) '.auth()->user()->name.' '.auth()->user()->last_name);

            return redirect()->intended('/');
        }
        toastr()->error('Usuario y/o contraseña Inválido. Válide nuevamente o comunicarse con la Area encargada');

        return redirect('login');
    }

    /****************************************************************************/
    public function logout(Request $request)
    {
        Auth::logout();
        toastr()->success('Sesión Terminada Correctamente!');

        return redirect()->intended('/login');
    }
}
