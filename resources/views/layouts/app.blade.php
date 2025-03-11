<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Captura - @yield('titulo')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="/path/to/your/favicon.svg">

    {{-- Meta Tags SEO --}}
    <meta name="description" content="Captura - Red Social Profesional">
    <meta name="keywords" content="red social, profesional, networking">

    @vite('resources/css/app.css')
    @stack('styles')
    @livewireStyles
</head>
<body class="bg-[#121212] text-gray-100 min-h-screen flex flex-col">
<header class="bg-[#1E1E1E] shadow-2xl sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="text-3xl font-black bg-clip-text text-transparent bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF] hover:from-[#6A2FDD] hover:to-[#C64FFF] transition duration-300">
            Captura
        </a>

        {{-- Navegación --}}
        <nav class="flex items-center space-x-4">
            @auth
                <div class="flex items-center space-x-4">
                    {{-- Botón Crear Post --}}
                    <a href="{{ route('posts.create') }}"
                       class="flex items-center bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF]
                                  text-white px-4 py-2 rounded-full
                                  hover:from-[#6A2FDD] hover:to-[#C64FFF]
                                  transition transform hover:scale-105 shadow-lg"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        Crear Post
                    </a>

                    {{-- Perfil y Logout --}}
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('posts.index', auth()->user()->username) }}"
                           class="text-gray-300 hover:text-[#8A4FFF] transition flex items-center"
                        >
                            <img
                                src="{{ auth()->user()->imagen ? asset('perfiles/' . auth()->user()->imagen) : asset('img/usuario.svg') }}"
                                alt="Perfil"
                                class="w-8 h-8 rounded-full mr-2 border-2 border-[#8A4FFF]"
                            >
                            <span class="font-semibold">{{ auth()->user()->username }}</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button
                                type="submit"
                                class="text-gray-400 hover:text-[#E66FFF] transition flex items-center"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                                Salir
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <div class="flex space-x-4">
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 border border-[#8A4FFF] text-[#8A4FFF] rounded-full
                                  hover:bg-[#8A4FFF] hover:text-white transition"
                    >
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF]
                                  text-white rounded-full
                                  hover:from-[#6A2FDD] hover:to-[#C64FFF] transition"
                    >
                        Crear Cuenta
                    </a>
                </div>
            @endguest
        </nav>
    </div>
</header>

{{-- Contenido Principal --}}
<main class="flex-grow container mx-auto mt-10 px-4 pb-20">
    <div class="bg-[#1E1E1E] rounded-2xl shadow-2xl p-8 min-h-[calc(100vh-250px)]">
        <h2 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF] text-center mb-12 pb-6">
            @yield('titulo')
        </h2>
        <div class="space-y-6">
            @yield('contenido')
        </div>
    </div>
</main>

{{-- Footer --}}
<footer class="bg-[#1E1E1E] mt-10 py-10">
    <div class="container mx-auto text-center">
        <p class="font-bold uppercase text-gray-300">
            Captura - Todos los derechos reservados {{ now()->year }}
        </p>
        <div class="flex justify-center space-x-4 mt-4 text-gray-500">
            <a href="#" class="hover:text-[#8A4FFF] transition">Términos</a>
            <a href="#" class="hover:text-[#8A4FFF] transition">Privacidad</a>
            <a href="#" class="hover:text-[#8A4FFF] transition">Contacto</a>
        </div>

        {{-- Redes Sociales --}}
        <div class="flex justify-center space-x-4 mt-6">
            <a href="#" class="text-gray-400 hover:text-[#8A4FFF] transition">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-[#8A4FFF] transition">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-[#8A4FFF] transition">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.148 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.148-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.948-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
            </a>
        </div>
    </div>
</footer>

@vite('resources/js/app.js')
@stack('scripts')
@livewireScripts
</body>
</html>
