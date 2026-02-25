@extends('layout')

@section('title', 'Mis Amigos - Tenderete')

@section('contenido')
<div class="max-w-6xl mx-auto py-12 px-4 text-center">
    <div class="mb-12">
        <h1 class="text-5xl font-black text-[#32424D] uppercase tracking-tighter mb-4">Tus Amigos</h1>
        <p class="text-xl text-gray-500 font-bold">Personas con las que puedes compartir y charlar.</p>
    </div>

    @if($amigos->isEmpty())
    <div class="bg-white rounded-[40px] shadow-xl p-16 border-4 border-dashed border-gray-100">
        <div class="w-32 h-32 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-8">
            <i class="bi bi-people text-6xl"></i>
        </div>
        <h3 class="text-3xl font-black text-gray-400 uppercase mb-4">Aún no tienes amigos</h3>
        <p class="text-lg text-gray-400 mb-10">¡No te preocupes! Inscríbete en actividades para conocer gente nueva.</p>
        <a href="{{ route('pagina.inicio') }}" class="inline-block bg-[#32424D] text-white font-black px-10 py-5 rounded-3xl shadow-lg hover:scale-105 transition-transform uppercase tracking-widest text-lg">
            Buscar actividades
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
        @foreach($amigos as $amigo)
        <div class="bg-white rounded-[40px] shadow-2xl p-8 border-4 border-white hover:border-indigo-100 transition-all group overflow-hidden relative">
            
            {{-- Fondo Decorativo --}}
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>

            <div class="relative flex flex-col items-center">
                <div class="relative mb-6">
                    <img src="{{ $amigo->perfil_foto ? '/' . $amigo->perfil_foto : 'https://ui-avatars.com/api/?name='.urlencode($amigo->name).'&size=128' }}" 
                         class="w-32 h-32 rounded-[35px] object-cover border-4 border-white shadow-xl">
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 border-4 border-white rounded-full"></div>
                </div>

                <h2 class="text-2xl font-black text-[#32424D] uppercase mb-1">{{ $amigo->name }}</h2>
                <p class="text-sm font-bold text-gray-400 mb-8 italic">Se unió en {{ $amigo->created_at->format('Y') }}</p>

                <div class="grid grid-cols-1 w-full gap-4">
                    {{-- LLAMAR --}}
                    <a href="tel:{{ $amigo->numero_telefono }}" 
                       class="flex items-center justify-center gap-4 bg-green-500 text-white font-black py-5 rounded-3xl shadow-lg hover:bg-green-600 hover:scale-[1.02] transition-all text-xl uppercase tracking-widest">
                        <i class="bi bi-telephone-fill"></i> Llamar
                    </a>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- CHATEAR --}}
                        <a href="{{ route('chat.show', $amigo->id) }}"
                           class="flex items-center justify-center gap-2 bg-indigo-500 text-white font-black py-4 rounded-3xl shadow-lg hover:bg-indigo-600 hover:scale-[1.02] transition-all uppercase tracking-widest text-sm">
                            <i class="bi bi-chat-dots-fill"></i> Chat
                        </a>

                        {{-- ELIMINAR --}}
                        <button onclick="confirmarEliminar('{{ $amigo->id }}', '{{ $amigo->name }}')"
                               class="flex items-center justify-center gap-2 bg-gray-100 text-gray-500 font-black py-4 rounded-3xl hover:bg-red-50 hover:text-red-500 hover:scale-[1.02] transition-all uppercase tracking-widest text-sm">
                            <i class="bi bi-trash3-fill"></i> Borrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<script>
    function confirmarEliminar(id, nombre) {
        Swal.fire({
            title: '¿Eliminar a ' + nombre + '?',
            text: "Dejaréis de ser amigos en la aplicación.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#bc6a50',
            cancelButtonColor: '#32424D',
            confirmButtonText: 'Sí, borrar',
            cancelButtonText: 'No, mantener'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/amigos/${id}/eliminar`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(r => r.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire('¡Eliminado!', data.message, 'success')
                        .then(() => location.reload());
                    }
                });
            }
        })
    }
</script>
@endsection