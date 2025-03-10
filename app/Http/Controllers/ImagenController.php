<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        // Crear instancia del ImageManager con el driver GD
        $manager = new ImageManager(new Driver());

        // Obtener la imagen del request
        $imagen = $request->file('file');

        // Generar nombre único
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        // Procesar la imagen
        $imagenServidor = $manager->read($imagen);
        $imagenServidor->resize(1000, 1000); // Usamos resize en lugar de scale

        // Guardar la imagen
        $imagenesPath = public_path('uploads') . '/' . $nombreImagen;
        $imagenServidor->save($imagenesPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
