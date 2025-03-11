@extends('layouts.app')

@section('titulo')
    Editar Perfil
@endsection

@section('contenido')
    <div class="min-h-screen bg-[#121212] flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-xl bg-[#1E1E1E] rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF] p-1">
                <div class="bg-[#1E1E1E] rounded-xl">
                    <div class="p-6 sm:p-10">
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-[#8A4FFF] to-[#E66FFF]">
                                Editar Perfil
                            </h2>
                            <p class="text-gray-400 mt-2">Actualiza tu información personal</p>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('perfil.store') }}"
                            enctype="multipart/form-data"
                            class="space-y-6"
                        >
                            @csrf

                            {{-- Vista previa de imagen --}}
                            <div class="flex justify-center mb-6">
                                <div class="relative">
                                    <img
                                        id="preview-image"
                                        src="{{ auth()->user()->imagen ? asset('perfiles/' . auth()->user()->imagen) : asset('img/usuario.svg') }}"
                                        alt="Vista previa de perfil"
                                        class="w-32 h-32 rounded-full object-cover border-4 border-[#8A4FFF] shadow-lg"
                                    />
                                    <label
                                        for="imagen"
                                        class="absolute bottom-0 right-0 bg-[#8A4FFF] text-white rounded-full p-2 cursor-pointer hover:bg-[#6A2FDD] transition"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </label>
                                </div>
                            </div>

                            {{-- Input de Username --}}
                            <div>
                                <label class="block text-gray-300 mb-2" for="username">
                                    Nombre de Usuario
                                </label>
                                <div class="relative">
                                    <input
                                        id="username"
                                        name="username"
                                        type="text"
                                        placeholder="Tu nombre de usuario"
                                        value="{{ auth()->user()->username }}"
                                        class="w-full px-4 py-3 bg-[#2A2A2A] text-gray-200 rounded-xl
                                           focus:outline-none focus:ring-2 focus:ring-[#8A4FFF]
                                           @error('username') border-2 border-red-500 @enderror"
                                    />
                                    @error('username')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    @enderror
                                </div>
                                @error('username')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Input de Imagen --}}
                            <div>
                                <label class="block text-gray-300 mb-2" for="imagen">
                                    Foto de Perfil
                                </label>
                                <input
                                    id="imagen"
                                    name="imagen"
                                    type="file"
                                    accept=".jpg, .jpeg, .png"
                                    class="w-full px-4 py-3 bg-[#2A2A2A] text-gray-200 rounded-xl
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-full file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-[#8A4FFF] file:text-white
                                       hover:file:bg-[#6A2FDD]"
                                />
                            </div>

                            {{-- Botón de Guardar --}}
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                <span>Guardar Cambios</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

    @push('scripts')
        <script>
            // Vista previa de imagen
            document.getElementById('imagen').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                }

                reader.readAsDataURL(file);
            });
        </script>
    @endpush
