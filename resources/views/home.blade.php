@extends('layouts.app')

@section('titulo')
    Inicio
@endsection

@section('contenido')
    <div class="container mx-auto px-4 py-8">
        {{-- Sección de Búsqueda --}}
        <div class="mb-10">
            <form action="{{ route('home') }}" method="GET" class="max-w-2xl mx-auto">
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        placeholder="Buscar usuarios o contenido..."
                        value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-3 bg-[#2A2A2A] text-gray-200 rounded-full
                           focus:outline-none focus:ring-2 focus:ring-[#8A4FFF]
                           transition duration-300"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button
                        type="submit"
                        class="absolute inset-y-0 right-0 px-4 bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF]
                           text-white rounded-r-full hover:from-[#6A2FDD] hover:to-[#C64FFF]
                           transition transform hover:scale-105"
                    >
                        Buscar
                    </button>
                </div>
            </form>
        </div>

        {{-- Sección de Usuarios --}}
        <div class="grid md:grid-cols-12 gap-8">
            {{-- Columna de Usuarios --}}
            <div class="md:col-span-4 lg:col-span-3">
                <div class="bg-[#1E1E1E] rounded-2xl shadow-2xl p-6">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#8A4FFF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Usuarios
                    </h3>

                    <div class="space-y-4">
                        @foreach($allUsers->take(6) as $user)
                            <a
                                href="{{ route('posts.index', $user->username) }}"
                                class="flex items-center space-x-3 hover:bg-[#2A2A2A] p-2 rounded-lg transition"
                            >
                                <img
                                    src="{{ $user->imagen ? asset('perfiles/' . $user->imagen) : asset('img/usuario.svg') }}"
                                    alt="Imagen de {{ $user->username }}"
                                    class="w-10 h-10 rounded-full border-2 border-[#8A4FFF]"
                                >
                                <div>
                                    <p class="text-white font-semibold">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-400">{{ $user->username }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    @if(request('search') && $searchUsers)
                        <div class="mt-6">
                            <h4 class="text-lg font-bold text-white mb-4">Resultados de Búsqueda</h4>
                            <div class="space-y-3">
                                @forelse($searchUsers as $user)
                                    <a
                                        href="{{ route('posts.index', $user->username) }}"
                                        class="flex items-center space-x-3 hover:bg-[#2A2A2A] p-2 rounded-lg transition"
                                    >
                                        <img
                                            src="{{ $user->imagen ? asset('perfiles/' . $user->imagen) : asset('img/usuario.svg') }}"
                                            alt="Imagen de {{ $user->username }}"
                                            class="w-10 h-10 rounded-full border-2 border-[#8A4FFF]"
                                        >
                                        <div>
                                            <p class="text-white font-semibold">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-400">{{ $user->username }}</p>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-gray-500 text-center">No se encontraron usuarios</p>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Columna de Publicaciones --}}
            <div class="md:col-span-8 lg:col-span-9">
                <div class="space-y-8">
                    @if($posts->count())
                        <x-listar-post :posts="$posts" />
                    @else
                        <div class="bg-[#1E1E1E] rounded-2xl p-10 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-[#8A4FFF] mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-2xl font-bold text-white mb-4">No hay publicaciones aún</h3>
                            <p class="text-gray-400">Sé el primero en compartir algo</p>
                            <a
                                href="{{ route('posts.create') }}"
                                class="mt-6 inline-block bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF]
                                   text-white px-6 py-3 rounded-full
                                   hover:from-[#6A2FDD] hover:to-[#C64FFF]
                                   transition transform hover:scale-105"
                            >
                                Crear Primera Publicación
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Opcional: Añadir animaciones o interacciones
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.addEventListener('focus', (e) => {
                    e.target.classList.add('ring-2', 'ring-[#8A4FFF]');
                });
                searchInput.addEventListener('blur', (e) => {
                    e.target.classList.remove('ring-2', 'ring-[#8A4FFF]');
                });
            }
        });
    </script>
@endpush
