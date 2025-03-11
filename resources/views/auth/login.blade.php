@extends('layouts.app')

@section('titulo')
    Iniciar Sesión
@endsection

@section('contenido')
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-4xl bg-[#1E1E1E] rounded-2xl shadow-2xl overflow-hidden grid md:grid-cols-2">
            {{-- Sección de Imagen --}}
            <div class="hidden md:block relative">
                <img
                    src="{{asset('img/login.jpg')}}"
                    alt="Imagen Login de Usuarios"
                    class="w-full h-full object-cover filter brightness-50"
                >
                <div class="absolute inset-0 bg-gradient-to-r from-[#8A4FFF]/70 to-[#E66FFF]/70 opacity-70"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-white px-8">
                        <h2 class="text-4xl font-bold mb-4">Bienvenido a Captura</h2>
                        <p class="text-xl">Conecta, Comparte, Crece</p>
                    </div>
                </div>
            </div>

            {{-- Sección de Formulario --}}
            <div class="flex items-center justify-center p-8">
                <div class="w-full max-w-md">
                    <h2 class="text-3xl font-bold text-center mb-8 text-transparent bg-clip-text bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF]">
                        Iniciar Sesión
                    </h2>

                    <form method="POST" action="{{ route('login') }}" novalidate class="space-y-6">
                        @csrf

                        {{-- Mensajes de Error --}}
                        @if(session('mensaje'))
                            <div class="bg-red-600/20 border border-red-600 text-red-400 px-4 py-3 rounded-lg mb-4">
                                {{ session('mensaje') }}
                            </div>
                        @endif

                        {{-- Input de Email --}}
                        <div>
                            <label for="email" class="block text-gray-300 mb-2">
                                Correo Electrónico
                            </label>
                            <div class="relative">
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    placeholder="Tu correo electrónico"
                                    value="{{ old('email') }}"
                                    class="w-full px-4 py-3 bg-[#2A2A2A] text-gray-200 rounded-xl
                                       focus:outline-none focus:ring-2 focus:ring-[#8A4FFF]
                                       @error('email') border-2 border-red-500 @enderror"
                                />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            @error('email')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input de Contraseña --}}
                        <div>
                            <label for="password" class="block text-gray-300 mb-2">
                                Contraseña
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    placeholder="Tu contraseña"
                                    class="w-full px-4 py-3 bg-[#2A2A2A] text-gray-200 rounded-xl
                                       focus:outline-none focus:ring-2 focus:ring-[#8A4FFF]
                                       @error('password') border-2 border-red-500 @enderror"
                                />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>
                            @error('password')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Recordar Sesión --}}
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                class="mr-2 rounded bg-[#2A2A2A] text-[#8A4FFF] focus:ring-[#8A4FFF]"
                            >
                            <label for="remember" class="text-gray-400 text-sm">
                                Mantener mi sesión abierta
                            </label>
                        </div>

                        {{-- Botón de Inicio de Sesión --}}
                        <button
                            type="submit"
                            class="w-full py-4 bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF]
                               text-white font-bold rounded-xl
                               hover:from-[#6A2FDD] hover:to-[#C64FFF]
                               transition duration-300
                               transform hover:scale-105
                               flex items-center justify-center space-x-2"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Iniciar Sesión</span>
                        </button>

                        {{-- Enlace de Registro --}}
                        <div class="text-center mt-4">
                            <p class="text-gray-400">
                                ¿No tienes una cuenta?
                                <a
                                    href="{{ route('register') }}"
                                    class="text-[#8A4FFF] hover:text-[#E66FFF] transition"
                                >
                                    Regístrate
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Opcional: Añadir animaciones o interacciones
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', (e) => {
                    e.target.classList.add('ring-2', 'ring-[#8A4FFF]');
                });
                input.addEventListener('blur', (e) => {
                    e.target.classList.remove('ring-2', 'ring-[#8A4FFF]');
                });
            });
        });
    </script>
@endpush
