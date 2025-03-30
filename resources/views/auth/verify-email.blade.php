@extends('layouts.app')

@section('contenido')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-[#1E1E1E] rounded-xl shadow-lg p-8 max-w-md mx-auto">
            <h1 class="text-2xl font-bold text-center mb-6 text-transparent bg-clip-text bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF]">
                Verifica tu correo electrónico
            </h1>
            <p class="text-gray-300 mb-6">
                Hemos enviado un enlace de verificación a tu correo. Si no lo recibes,
            <form method="POST" action="{{ route('verification.send') }}" class="inline">
                @csrf
                <button type="submit" class="text-[#8A4FFF] hover:text-[#E66FFF] font-medium">
                    haz clic aquí para reenviarlo
                </button>.
            </form>
            </p>
            <div class="text-center">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-[#8A4FFF] text-sm">
                    ← Volver al inicio
                </a>
            </div>
        </div>
    </div>
@endsection
