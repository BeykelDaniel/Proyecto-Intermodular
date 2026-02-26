@extends('layout')

@section('title', 'Perfil de ' . $usuario->name)

@section('contenido')
<div class="max-w-4xl mx-auto py-12 px-4">
    <div id="perfil-card" class="bg-white rounded-[40px] shadow-2xl p-10 border-4 border-[#32424D]/10 text-center transition-all">
        
        <div class="mb-8">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-indigo-600 font-black uppercase tracking-widest hover:underline mb-8 text-xs">
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
            <h3 class="text-xl font-black text-gray-400 uppercase tracking-widest mb-6 text-xs">Sobre esta persona</h3>
            <p class="text-2xl text-gray-700 font-bold leading-relaxed italic">
                @if($usuario->biografia)
                    "{{ $usuario->biografia }}"
                @else
                    "¡Hola! Soy {{ $usuario->name }} y me encanta participar en las actividades para conocer gente nueva."
                @endif
            </p>
        </div>

        {{-- CONTENEDOR DE ACCIONES DINÁMICO --}}
        <div id="contenedor-acciones-amistad">
            @php
                $solicitudPendiente = \DB::table('amigos')
                    ->where('amigo_id', auth()->id())
                    ->where('user_id', $usuario->id)
                    ->where('status', 'pendiente')
                    ->exists();
            @endphp

            @if($solicitudPendiente)
                <div id="botones-solicitud" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <button onclick="gestionarAmistad('{{ $usuario->id }}', 'aceptar')" 
                            class="btn-accion-perfil bg-green-500 text-white font-black py-6 rounded-3xl shadow-xl hover:bg-green-600 hover:scale-[1.02] transition-all text-2xl uppercase tracking-widest flex items-center justify-center gap-4">
                        <i class="bi bi-check-circle-fill"></i> Aceptar
                    </button>
                    <button onclick="gestionarAmistad('{{ $usuario->id }}', 'rechazar')"
                            class="btn-accion-perfil bg-red-500 text-white font-black py-6 rounded-3xl shadow-xl hover:bg-red-600 hover:scale-[1.02] transition-all text-2xl uppercase tracking-widest flex items-center justify-center gap-4">
                        <i class="bi bi-x-circle-fill"></i> Rechazar
                    </button>
                </div>
            @else
                <p class="text-gray-400 font-bold italic uppercase text-xs tracking-widest">Viendo perfil público</p>
            @endif
        </div>

        {{-- MENSAJE DE ÉXITO OCULTO --}}
        <div id="msg-perfil-exito" class="hidden animate-bounce mt-4 p-6 bg-green-100 rounded-[30px] border-2 border-green-200">
            <p class="text-green-700 font-black uppercase tracking-widest text-xl">
                <i class="bi bi-stars"></i> <span id="texto-exito">¡Hecho!</span>
            </p>
        </div>

        {{-- ERROR SILENCIOSO --}}
        <div id="error-perfil" class="hidden mt-4 p-4 bg-red-50 text-red-600 rounded-2xl font-bold uppercase text-xs border border-red-100">
            Ocurrió un error. Inténtalo de nuevo.
        </div>

    </div>
</div>

<script>
    function gestionarAmistad(id, accion) {
        const botones = document.getElementById('botones-solicitud');
        const cargando = document.getElementById('error-perfil');
        const exitoDiv = document.getElementById('msg-perfil-exito');
        const card = document.getElementById('perfil-card');

        // Desactivar botones para evitar doble click
        const btnActivos = document.querySelectorAll('.btn-accion-perfil');
        btnActivos.forEach(b => { b.disabled = true; b.style.opacity = '0.5'; });

        fetch(`/amigos/${id}/${accion}`, { 
            method: 'POST', 
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            } 
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                // Ocultamos botones con efecto
                botones.classList.add('hidden');
                
                // Mostramos el mensaje de éxito
                exitoDiv.classList.remove('hidden');
                document.getElementById('texto-exito').innerText = 
                    accion === 'aceptar' ? '¡Ahora sois amigos!' : 'Solicitud rechazada';

                // Si aceptó, podemos redirigir tras un segundo para que vea el éxito
                setTimeout(() => {
                    window.location.href = (accion === 'aceptar') 
                        ? '{{ route("pagina.amigos") }}' 
                        : '{{ route("pagina.inicio") }}';
                }, 1500);
            } else {
                mostrarError();
            }
        })
        .catch(() => mostrarError());

        function mostrarError() {
            cargando.classList.remove('hidden');
            btnActivos.forEach(b => { b.disabled = false; b.style.opacity = '1'; });
            card.classList.add('animate-shake');
            setTimeout(() => card.classList.remove('animate-shake'), 400);
        }
    }
</script>

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-10px); }
    50% { transform: translateX(10px); }
    75% { transform: translateX(-10px); }
}
.animate-shake { animation: shake 0.4s ease-in-out; }
</style>
@endsection