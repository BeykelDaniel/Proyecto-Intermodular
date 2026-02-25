@extends('layout')

@section('title', 'Perfil de ' . $usuario->name)

@section('contenido')
<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="bg-white rounded-[40px] shadow-2xl p-10 border-4 border-[#32424D]/10 text-center">
        
        <div class="mb-8">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-indigo-600 font-black uppercase tracking-widest hover:underline mb-8">
                <i class="bi bi-arrow-left"></i> Volver atrás
            </a>
        </div>

        <div class="relative inline-block mb-8">
            <img src="{{ $usuario->perfil_foto ? '/' . $usuario->perfil_foto : 'https://ui-avatars.com/api/?name='.urlencode($usuario->name).'&size=200' }}" 
                 class="w-48 h-48 rounded-[50px] object-cover border-8 border-white shadow-2xl mx-auto">
            <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-green-500 border-4 border-white rounded-full"></div>
        </div>

        <h1 class="text-5xl font-black text-[#32424D] uppercase tracking-tighter mb-4">{{ $usuario->name }}</h1>
        
        <div class="flex flex-wrap justify-center gap-4 mb-10">
            <span class="px-6 py-3 bg-indigo-50 text-indigo-700 rounded-2xl font-black uppercase tracking-widest text-sm">
                <i class="bi bi-calendar-event mr-2"></i> {{ \Carbon\Carbon::parse($usuario->fecha_nacimiento)->age }} años
            </span>
            <span class="px-6 py-3 bg-orange-50 text-[#bc6a50] rounded-2xl font-black uppercase tracking-widest text-sm">
                <i class="bi bi-gender-ambiguous mr-2"></i> {{ ucfirst($usuario->genero) }}
            </span>
        </div>

        <div class="bg-gray-50 rounded-[35px] p-10 border-2 border-gray-100 mb-12">
            <h3 class="text-xl font-black text-gray-400 uppercase tracking-widest mb-6">Sobre esta persona</h3>
            <p class="text-2xl text-gray-700 font-bold leading-relaxed italic">
                @if($usuario->biografia)
                    "{{ $usuario->biografia }}"
                @else
                    "¡Hola! Soy {{ $usuario->name }} y me encanta participar en las actividades de Tenderete para conocer gente nueva y compartir buenos momentos."
                @endif
            </p>
        </div>

        {{-- ACCIONES DE AMISTAD (SI ES UNA SOLICITUD PENDIENTE) --}}
        @php
            $solicitudPendiente = \DB::table('amigos')
                ->where('amigo_id', auth()->id())
                ->where('user_id', $usuario->id)
                ->where('status', 'pendiente')
                ->exists();
        @endphp

        @if($solicitudPendiente)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <button onclick="aceptarSolicitud('{{ $usuario->id }}')" 
                    class="bg-green-500 text-white font-black py-6 rounded-3xl shadow-xl hover:bg-green-600 hover:scale-[1.02] transition-all text-2xl uppercase tracking-widest flex items-center justify-center gap-4">
                <i class="bi bi-check-circle-fill"></i> Aceptar Amistad
            </button>
            <button onclick="rechazarSolicitud('{{ $usuario->id }}')"
                    class="bg-red-500 text-white font-black py-6 rounded-3xl shadow-xl hover:bg-red-600 hover:scale-[1.02] transition-all text-2xl uppercase tracking-widest flex items-center justify-center gap-4">
                <i class="bi bi-x-circle-fill"></i> Rechazar
            </button>
        </div>
        @else
            <p class="text-gray-400 font-bold italic">Viendo perfil público</p>
        @endif

    </div>
</div>

<script>
    function aceptarSolicitud(id) {
        fetch(`/amigos/${id}/aceptar`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
            .then(r => r.json())
            .then(data => {
                if(data.success) {
                    Swal.fire('¡Amigos ahora!', 'Has aceptado la solicitud de amistad.', 'success')
                    .then(() => window.location.href = '{{ route('pagina.amigos') }}');
                }
            });
    }

    function rechazarSolicitud(id) {
        fetch(`/amigos/${id}/rechazar`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
            .then(r => r.json())
            .then(data => {
                if(data.success) {
                    Swal.fire('Solicitud rechazada', '', 'info')
                    .then(() => window.location.href = '{{ route('pagina.inicio') }}');
                }
            });
    }
</script>
@endsection
