<div>
    {{-- Sección de usuarios si existe --}}
    @if($users && $users->count())
        <div class="mb-4">
            <h3 class="text-lg font-bold">Usuarios Encontrados</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($users as $user)
                    <a href="{{ route('posts.index', $user->username) }}" class="bg-gray-200 p-2 rounded">
                        {{ $user->username }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Tu código existente de posts --}}
    @if($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($posts as $post)
                <div>
                    <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del Post {{ $post->titulo }}" class="w-full h-60 object-cover" >
                    </a>
                </div>
            @endforeach
        </div>
        <div class="my-10">
            {{ $posts->links() }}
        </div>
    @else
        <p class="text-center">No hay publicaciones disponibles.</p>
    @endif
</div>
