@extends('layouts.app')

@section('titulo')
    Pagina Principal
@endsection

@section('contenido')
    <div class="container mx-auto">
        {{-- Buscador de usuarios --}}
        <div class="mb-4">
            <form action="{{ route('home') }}" method="GET" class="flex">
                <input
                    type="text"
                    name="search"
                    placeholder="Buscar usuarios..."
                    class="flex-grow p-2 border rounded-l"
                    value="{{ request('search') }}"
                >
                <button
                    type="submit"
                    class="bg-blue-500 text-white p-2 rounded-r"
                >
                    Buscar
                </button>
            </form>
        </div>

        {{-- Listado de todos los usuarios --}}
        <div class="bg-white shadow rounded p-4 mb-4">
            <h3 class="text-lg font-bold mb-2">Usuarios</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($allUsers as $user)
                    <a
                        href="{{ route('posts.index', $user->username) }}"
                        class="block p-2 border rounded hover:bg-gray-100"
                    >
                        <div class="flex items-center">
                            <img
                                src="{{ $user->imagen ? asset('perfiles/' . $user->imagen) : asset('img/usuario.svg') }}"
                                alt="Imagen de {{ $user->username }}"
                                class="w-10 h-10 rounded-full mr-2"
                            >
                            <div>
                                <p class="font-bold">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $user->username }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Resultados de búsqueda (si hay) --}}
        @if(request('search') && $searchUsers)
            <div class="bg-white shadow rounded p-4 mb-4">
                <h3 class="text-lg font-bold mb-2">Resultados de Búsqueda</h3>
                @if($searchUsers->count())
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($searchUsers as $user)
                            <a
                                href="{{ route('posts.index', $user->username) }}"
                                class="block p-2 border rounded hover:bg-gray-100"
                            >
                                <div class="flex items-center">
                                    <img
                                        src="{{ $user->imagen ? asset('perfiles/' . $user->imagen) : asset('img/usuario.svg') }}"
                                        alt="Imagen de {{ $user->username }}"
                                        class="w-10 h-10 rounded-full mr-2"
                                    >
                                    <div>
                                        <p class="font-bold">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->username }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No se encontraron usuarios</p>
                @endif
            </div>
        @endif

        {{-- Listado de posts usando el componente --}}
        <x-listar-post :posts="$posts" />
    </div>
@endsection
