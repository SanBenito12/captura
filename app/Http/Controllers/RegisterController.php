<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Modificar el Request (slug para username)
        $request->merge(['username' => Str::slug($request->username)]);

        // Validación
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'username' => "required|unique:users|min:3|max:20",
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Enviar correo de verificación (¡NUEVO!)
        $user->sendEmailVerificationNotification();

        // Redirigir a página de "verifica tu email" (¡CAMBIO IMPORTANTE!)
        return redirect()->route('verification.notice')->with([
            'message' => '¡Registro exitoso! Por favor verifica tu correo electrónico.',
            'email' => $user->email // Opcional: para mostrar el email en la vista
        ]);
    }
}
