<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ImagenController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', HomeController::class)->middleware('auth')->name('home');

// Buscador de usuarios
Route::get('/buscar-usuarios', [PerfilController::class, 'buscar'])->name('usuarios.buscar');
// Rutas de autenticación
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// RUTA PERFIL
Route::middleware(['auth'])->group(function () {
    Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
});
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

// Rutas para posts públicos
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');

Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');
});

//LIKES FOTOS
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

// Siguiendo Usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');
