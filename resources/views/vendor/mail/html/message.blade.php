<x-mail::layout>
    {{-- Header --}}
    <x-slot:header>
        <x-mail::header :url="config('app.url')">
            <span style="background: linear-gradient(45deg, #8A4FFF, #E66FFF); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Captura
            </span>
        </x-mail::header>
    </x-slot:header>

    {{-- Body --}}
    <div style="color: #e2e8f0;">
        {{ $slot }}
    </div>

    {{-- Footer --}}
    <x-slot:footer>
        <x-mail::footer>
            © {{ date('Y') }} Captura. Todos los derechos reservados.
        </x-mail::footer>
    </x-slot:footer>
</x-mail::layout>
