@extends('layouts.app')

@section('titulo')
    Publicación
@endsection

@section('contenido')
    <div class="min-h-screen bg-[#121212] py-10">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-8">
                {{-- Sección de Imagen Principal --}}
                <div class="bg-[#1E1E1E] rounded-2xl overflow-hidden shadow-2xl">
                    <div class="relative">
                        {{-- Imagen del Post --}}
                        <div class="relative">
                            <img
                                src="{{ asset('uploads') . '/' . $post->imagen }}"
                                alt="Imagen de la Publicación"
                                class="w-full h-[500px] object-cover transition duration-500 transform hover:scale-105"
                            >

                            {{-- Overlay de Información del Autor --}}
                            <div class="absolute top-4 left-4">
                                <div class="flex items-center space-x-3 bg-black/50 rounded-full px-4 py-2">
                                    <img
                                        src="{{ $post->user->imagen ? asset('perfiles/' . $post->user->imagen) : asset('img/usuario.svg') }}"
                                        alt="Imagen de perfil"
                                        class="w-10 h-10 rounded-full border-2 border-white/30"
                                    >
                                    <div>
                                        <p class="text-white font-semibold">{{ $post->user->username }}</p>
                                        <p class="text-xs text-gray-300">
                                            {{ $post->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Acciones de Interacción --}}
                        <div class="p-6 bg-[#1E1E1E]">
                            <div class="flex justify-between items-center">
                                <div class="flex space-x-4">
                                    @auth
                                        <livewire:like-post :post="$post" />

                                        {{-- Botón de Comentarios --}}
                                        <button class="text-gray-300 hover:text-white transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                        </button>
                                    @endauth
                                </div>

                                {{-- Categoría o Etiquetas --}}
                                @if($post->categoria)
                                    <span class="bg-[#8A4FFF]/20 text-[#8A4FFF] text-xs font-medium px-3 py-1 rounded-full">
                                    {{ $post->categoria }}
                                </span>
                                @endif
                            </div>

                            {{-- Descripción del Post --}}
                            <div class="mt-4">
                                <h2 class="text-xl font-bold text-white mb-2">{{ $post->titulo }}</h2>
                                <p class="text-gray-300 leading-relaxed">
                                    {{ $post->descripcion }}
                                </p>
                            </div>

                            {{-- Botón de Eliminar (Solo para el autor) --}}
                            @auth
                                @if($post->user_id === auth()->user()->id)
                                    <div class="mt-6">
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button
                                                type="submit"
                                                class="w-full bg-red-600/20 text-red-400 py-3 rounded-lg
                                                   hover:bg-red-600/30 transition-colors
                                                   flex items-center justify-center space-x-2"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                <span>Eliminar Publicación</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>

                {{-- Sección de Comentarios --}}
                <div class="space-y-6">
                    {{-- Formulario de Comentarios --}}
                    @auth
                        <div class="bg-[#1E1E1E] rounded-2xl p-6 shadow-xl">
                            <h3 class="text-xl font-bold text-center text-white mb-4">
                                Agregar Comentario
                            </h3>

                            @if(session('mensaje'))
                                <div class="bg-green-600/20 border border-green-600 text-green-400 px-4 py-3 rounded-lg relative mb-4">
                                    {{ session('mensaje') }}
                                </div>
                            @endif

                            <form action="{{ route('comentarios.store', ['post' => $post, 'user' => $user]) }}" method="POST">
                                @csrf
                                <textarea
                                    name="comentario"
                                    placeholder="Escribe tu comentario..."
                                    class="w-full bg-[#2A2A2A] text-gray-200 rounded-lg p-3
                                       focus:outline-none focus:ring-2 focus:ring-[#8A4FFF]
                                       transition duration-300"
                                    rows="4"
                                ></textarea>

                                @error('comentario')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror

                                <button
                                    type="submit"
                                    class="w-full bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF]
                                       text-white py-3 rounded-lg
                                       hover:from-[#6A2FDD] hover:to-[#C64FFF]
                                       transition-colors mt-4
                                       transform hover:scale-105"
                                >
                                    Publicar Comentario
                                </button>
                            </form>
                        </div>
                    @endauth

                    {{-- Lista de Comentarios --}}
                    <div class="bg-[#1E1E1E] rounded-2xl shadow-xl">
                        <div class="p-6 border-b border-gray-800">
                            <h3 class="text-xl font-bold text-white">
                                Comentarios ({{ $post->comentarios->count() }})
                            </h3>
                        </div>

                        <div class="max-h-[500px] overflow-y-auto">
                            @forelse($post->comentarios as $comentario)
                                <div class="p-4 border-b border-gray-800 hover:bg-[#2A2A2A] transition">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <img
                                            src="{{ $comentario->user->imagen ? asset('perfiles/' . $comentario->user->imagen) : asset('img/usuario.svg') }}"
                                            alt="Imagen de perfil"
                                            class="w-8 h-8 rounded-full"
                                        >
                                        <a href="{{ route('posts.index', $comentario->user) }}" class="font-bold text-white hover:text-[#8A4FFF]">
                                            {{ $comentario->user->username }}
                                        </a>
                                        <span class="text-xs text-gray-500">
                                        {{ $comentario->created_at->diffForHumans() }}
                                    </span>
                                    </div>
                                    <p class="text-gray-300">
                                        {{ $comentario->comentario }}
                                    </p>
                                </div>
                            @empty
                                <div class="text-center p-6 text-gray-500">
                                    No hay comentarios aún
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Opcional: Añadir animaciones o interacciones
        document.addEventListener('DOMContentLoaded', () => {
            const commentForm = document.querySelector('form');
            if (commentForm) {
                commentForm.addEventListener('submit', (e) => {
                    const submitButton = e.target.querySelector('button[type="submit"]');
                    submitButton.disabled = true;
                    submitButton.innerHTML = 'Publicando...';
                });
            }
        });
    </script>
@endpush
