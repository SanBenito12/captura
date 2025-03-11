@extends('layouts.app')

@section('titulo')
    Crear Publicación
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@section('contenido')
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-5xl bg-[#1E1E1E] rounded-2xl shadow-2xl overflow-hidden grid md:grid-cols-2 gap-8 p-8">
            {{-- Sección de Dropzone --}}
            <div class="flex items-center justify-center">
                <div class="w-full">
                    <form
                        action="{{ route('imagenes.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        id="dropzone"
                        class="dropzone border-dashed border-2 border-[#8A4FFF] w-full h-96 rounded-xl
                           flex flex-col justify-center items-center
                           bg-[#2A2A2A] hover:bg-[#2A2A2A]/50 transition-all duration-300"
                    >
                        @csrf
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-[#8A4FFF] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-400 mb-2">Arrastra y suelta tu imagen aquí</p>
                            <p class="text-sm text-gray-500">O haz clic para seleccionar</p>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sección de Formulario --}}
            <div class="flex items-center justify-center">
                <div class="w-full max-w-md">
                    <h2 class="text-3xl font-bold text-center mb-8 text-transparent bg-clip-text bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF]">
                        Detalles de la Publicación
                    </h2>

                    <form action="{{ route('posts.store') }}" method="POST" novalidate class="space-y-6">
                        @csrf
                        {{-- Título --}}
                        <div>
                            <label for="titulo" class="block text-gray-300 mb-2">
                                Título
                            </label>
                            <div class="relative">
                                <input
                                    id="titulo"
                                    name="titulo"
                                    type="text"
                                    placeholder="Título de la publicación"
                                    value="{{ old('titulo') }}"
                                    class="w-full px-4 py-3 bg-[#2A2A2A] text-gray-200 rounded-xl
                                       focus:outline-none focus:ring-2 focus:ring-[#8A4FFF]
                                       @error('titulo') border-2 border-red-500 @enderror"
                                />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                            </div>
                            @error('titulo')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <label for="descripcion" class="block text-gray-300 mb-2">
                                Descripción
                            </label>
                            <textarea
                                id="descripcion"
                                name="descripcion"
                                placeholder="Describe tu publicación"
                                rows="4"
                                class="w-full px-4 py-3 bg-[#2A2A2A] text-gray-200 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-[#8A4FFF]
                                   @error('descripcion') border-2 border-red-500 @enderror"
                            >{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo oculto para imagen --}}
                        <input
                            name="imagen"
                            type="hidden"
                            value="{{ old('imagen') }}"
                        />
                        @error('imagen')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror

                        {{-- Botón de Publicar --}}
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Crear Publicación</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.options.dropzone = {
            dictDefaultMessage: "",
            acceptedFiles: ".png,.jpg,.jpeg,.gif",
            addRemoveLinks: true,
            dictRemoveFile: "Eliminar archivo",
            maxFiles: 1,
            uploadMultiple: false,
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
            }
        };

        // Animaciones adicionales
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('input, textarea');
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
