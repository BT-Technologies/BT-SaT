<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
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

    //use AuthenticatesUsers;

    public function index()
	{
	    // Check if the user is logged
	    if (Auth::check()) {
	
	        // dashboard if logged
	        return view('dashboard');
	    }
	
	    // Si no está logado le mostramos la vista con el formulario de login
	    return view('login');
	}

    public function login(Request $request)
	{
	    // 
	    $request->validate([
	        'email' => 'required',
	        'password' => 'required',
	    ]);
	
	    // Almacenamos las credenciales de email y contraseña
	    $credentials = $request->only('email', 'password');
	
	    // check if user exist and pass to dashboard view
	    if (Auth::attempt($credentials)) {
	        return redirect()->intended('logged')
	            ->withSuccess('Logado Correctamente');
	    }
	
	    //if the user is not here .... return to login view
	    return redirect("/")->withSuccess('Lo sentimos, estas credenciales no son correctas');
	}
    public function logged()
	{
	    if (Auth::check()) {
	        return view('dashboard');   
	    }
        
	    return redirect("login")->withSuccess('No tienes acceso, por favor inicia sesión');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /*  public function __construct()
    {
        $this->middleware('guest')->except('logout');
    } */
}
