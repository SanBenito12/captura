@extends('layouts.app')

@section('titulo')
    Perfil Profesional: {{ $user->username }}
@endsection

@section('contenido')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-[#1E1E1E] shadow-2xl rounded-2xl overflow-hidden">
            {{-- Portada --}}
            <div class="relative h-56 bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF]">
                <div class="absolute bottom-0 left-0 right-0 p-6 flex items-end">
                    <div class="relative">
                        <div class="w-40 h-40 md:w-48 md:h-48 rounded-full
                        bg-gradient-to-r from-[#6A2FDD] to-[#C64FFF]
                        p-1.5 shadow-2xl">
                            <img
                                src="{{ $user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/usuario.svg') }}"
                                alt="Foto de perfil profesional"
                                class="w-full h-full rounded-full object-cover
                           border-4 border-[#1E1E1E]
                           transform transition duration-300
                           hover:scale-105 hover:rotate-3"
                            />
                        </div>
                        @auth
                            @if($user->id === auth()->user()->id)
                                <a href="{{ route('perfil.index') }}"
                                   class="absolute bottom-2 right-2 bg-[#8A4FFF] text-white rounded-full p-2
                              hover:bg-[#6A2FDD] transition-all duration-300
                              transform hover:scale-110 shadow-lg"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                            @endif
                        @endauth
                    </div>
                    <div class="ml-6 text-white">
                        <h2 class="text-2xl font-bold">{{ $user->username }}</h2>
                        <p class="text-sm">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6 p-6">
                {{-- Columna de Estadísticas --}}
                <div class="col-span-1 bg-[#2A2A2A] p-4 rounded-lg">
                    <h3 class="text-lg font-bold text-white mb-4">Estadísticas Profesionales</h3>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <span class="block text-2xl font-bold text-[#8A4FFF]">{{ $user->followers->count() }}</span>
                            <span class="text-sm text-gray-400">Seguidores</span>
                        </div>
                        <div>
                            <span class="block text-2xl font-bold text-[#8A4FFF]">{{ $user->followings->count() }}</span>
                            <span class="text-sm text-gray-400">Siguiendo</span>
                        </div>
                        <div>
                            <span class="block text-2xl font-bold text-[#8A4FFF]">{{ $user->posts->count() }}</span>
                            <span class="text-sm text-gray-400">Publicaciones</span>
                        </div>
                    </div>

                    @auth
                        @if($user->id !== auth()->user()->id)
                            <div class="mt-4 text-center">
                                @if(!$user->siguiendo(auth()->user()))
                                    <form action="{{ route('users.follow', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF] text-white py-2 rounded-lg hover:from-[#6A2FDD] hover:to-[#C64FFF] transition">
                                            Conectar
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-600/20 text-red-400 py-2 rounded-lg hover:bg-red-600/30 transition">
                                            Desconectar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    @endauth
                </div>

                {{-- Columna de Información Adicional --}}
                <div class="col-span-1 bg-[#2A2A2A] p-4 rounded-lg">
                    <h3 class="text-lg font-bold text-white mb-4">Información Profesional</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-semibold text-gray-400">Empresa</span>
                            <p class="text-white">{{ $user->empresa ?? 'Stack' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-400">Cargo</span>
                            <p class="text-white">{{ $user->cargo ?? 'Aspirante' }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-400">Ubicación</span>
                            <p class="text-white">{{ $user->ubicacion ?? 'Mexico' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Columna de Habilidades --}}
                <div class="col-span-1 bg-[#2A2A2A] p-4 rounded-lg">
                    <h3 class="text-lg font-bold text-white mb-4">Habilidades</h3>
                    <div class="flex flex-wrap gap-2">
                        @if($user->habilidades)
                            @foreach(explode(',', $user->habilidades) as $habilidad)
                                <span class="bg-[#8A4FFF]/20 text-[#8A4FFF] text-xs font-medium px-3 py-1 rounded-full">
                                {{ trim($habilidad) }}
                            </span>
                            @endforeach
                        @else
                            <p class="text-gray-400">No hay habilidades registradas</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sección de Publicaciones --}}
            <div class="bg-[#121212] p-6">
                <h2 class="text-2xl font-bold text-center text-white mb-6">Publicaciones Recientes</h2>
                <x-listar-post :posts="$posts" />
            </div>
        </div>
    </div>
@endsection
