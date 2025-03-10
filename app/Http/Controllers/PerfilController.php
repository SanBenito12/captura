<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class PerfilController extends Controller
{
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        $request->merge([
            'username' => Str::lower(str_replace(' ', '', $request->username))
        ]);

        $request->validate([
            'username' => [
                'required',
                'unique:users,username,' . auth()->user()->id,
                'min:3',
                'max:20',
                'regex:/^[a-z0-9._]+$/',
                'not_in:editar-perfil,login,register,logout,posts,imagenes'
            ]
        ]);

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            // Crear una instancia de ImageManager con el driver GD
            $manager = new ImageManager(new Driver());
            $imagenServidor = $manager->read($imagen)->cover(1000, 1000);

            // Guardar la imagen procesada
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        // Guardar cambios en la base
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        // Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }

    public function buscar(Request $request)
    {
        $busqueda = $request->busqueda;

        $usuarios = User::where('username', 'like', '%' . $busqueda . '%')
            ->orWhere('name', 'like', '%' . $busqueda . '%')
            ->get();

        return response()->json($usuarios);
    }
}
