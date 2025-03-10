@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    <div class="container mx-auto md:flex space-y-6 md:space-y-0 md:space-x-6">
        <div class="md:w-1/2 bg-white rounded-xl shadow-lg overflow-hidden">
            <img
                src="{{ asset('uploads') . '/' . $post->imagen }}"
                alt="Imagen del Post {{ $post->titulo }}"
                class="w-full h-96 object-cover"
            >

            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    @auth
                        <livewire:like-post :post="$post" />
                    @endauth
                </div>

                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <img
                            src="{{ $post->user->imagen ? asset('perfiles/' . $post->user->imagen) : asset('img/usuario.svg') }}"
                            alt="Imagen de perfil"
                            class="w-10 h-10 rounded-full"
                        >
                        <div>
                            <p class="font-bold text-lg text-gray-800">{{ $post->user->username }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $post->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <p class="text-gray-700 leading-relaxed">
                        {{ $post->descripcion }}
                    </p>

                    @auth
                        @if($post->user_id === auth()->user()->id)
                            <form method="POST" action="{{ route('posts.destroy', $post) }}" class="mt-4">
                                @method('DELETE')
                                @csrf
                                <input
                                    type="submit"
                                    value="Eliminar Publicación"
                                    class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 p-3 rounded-lg text-white font-bold w-full transition-all duration-300 ease-in-out transform hover:scale-105"
                                />
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="md:w-1/2">
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                @auth()
                    <h2 class="text-2xl font-bold text-center text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-pink-500 mb-6">
                        Agrega un Nuevo Comentario
                    </h2>

                    @if(session('mensaje'))
                        <div class="bg-green-500 p-3 rounded-lg mb-6 text-white text-center uppercase font-bold shadow-md">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                    <form action="{{ route('comentarios.store', ['post' => $post, 'user' => $user]) }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="comentario" class="mb-2 block uppercase text-gray-600 font-bold">
                                Escribe un Comentario
                            </label>
                            <textarea
                                id="comentario"
                                name="comentario"
                                placeholder="Añade un Comentario"
                                class="border-2 border-gray-300 p-3 w-full rounded-lg focus:outline-none focus:border-purple-500 transition duration-300 @error('name') border-red-500 @enderror"
                            ></textarea>

                            @error('comentario')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <input
                            type="submit"
                            value="Comentar"
                            class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg shadow-md hover:shadow-xl transform hover:scale-105 duration-300"
                        />
                    </form>
                @endauth

                <div class="bg-gray-50 rounded-lg shadow-inner mt-6 max-h-96 overflow-y-auto">
                    @if ($post->comentarios->count())
                        @foreach($post->comentarios as $comentario)
                            <div class="p-5 border-b border-gray-200 hover:bg-gray-100 transition duration-300">
                                <div class="flex items-center space-x-3 mb-2">
                                    <img
                                        src="{{ $comentario->user->imagen ? asset('perfiles/' . $comentario->user->imagen) : asset('img/usuario.svg') }}"
                                        alt="Imagen de perfil"
                                        class="w-8 h-8 rounded-full"
                                    >
                                    <a href="{{ route('posts.index', $comentario->user) }}" class="font-bold text-gray-800 hover:text-purple-600 transition">
                                        {{ $comentario->user->username}}
                                    </a>
                                </div>
                                <p class="text-gray-700 mb-2">
                                    {{ $comentario->comentario }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $comentario->created_at->diffForHumans()}}
                                </p>
                            </div>
                        @endforeach
                    @else
                        <p class="p-10 text-center text-gray-500 italic">
                            No Hay Comentarios Aún
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
