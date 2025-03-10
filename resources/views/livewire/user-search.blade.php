<div>
    <div class="mb-4">
        <input
            type="text"
            wire:model.debounce.500ms="search"
            placeholder="Buscar usuarios..."
            class="w-full p-2 border rounded"
        >
    </div>

    @if($search && $users->count())
        <div class="bg-white shadow rounded p-4 mb-4">
            <h2 class="text-xl font-bold mb-2">Resultados de Usuarios</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($users as $user)
                    <div class="text-center">
                        <a href="{{ route('posts.index', $user->username) }}">
                            <img
                                src="{{ $user->imagen ? asset('perfiles/' . $user->imagen) : asset('img/usuario.svg') }}"
                                alt="Imagen de {{ $user->name }}"
                                class="w-20 h-20 rounded-full mx-auto"
                            >
                            <p>{{ $user->name }}</p>
                            <p class="text-gray-500">{{ $user->username }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
