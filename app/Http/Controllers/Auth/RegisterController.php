<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Rules\PlanRule;

class RegisterController extends Controller
{
public function register(Request $request)
{
    $validator = $this->validator($request->all());
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = $this->create($request->all());

    // Additional logic or redirection after successful registration

    return redirect()->route('login')->with('message', 'Se ha registrado correctamente, vaya al correo registrado, para confirmar su cuenta, este paso es necesario, para usar la cuenta.');
}

protected function create(array $data)
{
    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'plan' => $data['plan'],
    ]);
}

protected function validator(array $data)
{
    return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'plan' => ['required', new PlanRule(), 'min:1'],
    ]);

}
}
