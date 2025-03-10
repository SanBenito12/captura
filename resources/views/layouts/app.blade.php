<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Captura - @yield('titulo')</title>
    @vite('resources/css/app.css')
    @stack('styles')
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen">
<header class="bg-white shadow-lg">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-pink-500 hover:from-pink-500 hover:to-purple-500 transition duration-300">
            Captura
        </a>

        @auth
            <nav class="flex items-center space-x-4">
                <a href="{{ route('posts.create') }}" class="flex items-center bg-gradient-to-r from-purple-500 to-pink-500 text-white px-4 py-2 rounded-full shadow-md hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Crear Post
                </a>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('posts.index', auth()->user()->username) }}" class="text-gray-700 hover:text-purple-600 transition">
                        <span class="font-semibold">{{ auth()->user()->username }}</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-red-500 transition">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </nav>
        @endauth

        @guest
            <nav class="flex space-x-4">
                <a href="{{ route('login') }}" class="px-4 py-2 border border-purple-500 text-purple-500 rounded-full hover:bg-purple-500 hover:text-white transition">
                    Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full hover:from-pink-500 hover:to-purple-500 transition">
                    Crear Cuenta
                </a>
            </nav>
        @endguest
    </div>
</header>

<main class="container mx-auto mt-10 px-4 pb-20">
    <div class="bg-white rounded-xl shadow-2xl p-8 min-h-[calc(100vh-250px)]">
        <h2 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-pink-500 text-center mb-12 pb-6">
            @yield('titulo')
        </h2>
        <div class="space-y-6">
            @yield('contenido')
        </div>
    </div>
</main>

<footer class="mt-10 text-center p-5 text-gray-500">
    <div class="container mx-auto">
        <p class="font-bold uppercase">
            Captura - Todos los derechos reservados {{ now()->year }}
        </p>
        <div class="flex justify-center space-x-4 mt-4 text-gray-400">
            <a href="#" class="hover:text-purple-500 transition">Términos</a>
            <a href="#" class="hover:text-purple-500 transition">Privacidad</a>
            <a href="#" class="hover:text-purple-500 transition">Contacto</a>
        </div>
    </div>
</footer>

@vite('resources/js/app.js')
@stack('scripts')
@livewireScripts
</body>
</html>
