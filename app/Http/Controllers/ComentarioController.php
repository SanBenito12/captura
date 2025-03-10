<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(request $request, User $user,Post $post)
    {

        //VALIDAR
        $request->validate([
            'comentario' => 'required|max:255',
        ]);

        //almacenar el resultado
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario,
        ]);

        //imprimir comentario
        return back()->with('mensaje', 'Comentario enviado');
    }
}
