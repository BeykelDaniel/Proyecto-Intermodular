@extends('layout')

@section('title', 'Mis Amigos - Tenderete')

@section('contenido')
<div class="max-w-6xl mx-auto py-12 px-4 text-center">
    <div class="mb-12">
        <h1 class="text-5xl font-black text-[#32424D] uppercase tracking-tighter mb-4">Tus Amigos</h1>
        <p class="text-xl text-gray-500 font-bold italic text-sm uppercase">Personas con las que puedes compartir y charlar.</p>
    </div>

    {{-- ESTADO VACÍO (Se muestra si no hay amigos o si borras al último) --}}
    <div id="contenedor-amigos-vacio" class="{{ $amigos->isEmpty() ? '' : 'hidden' }}">
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
    </div>

    @if(!$amigos->isEmpty())
    <div id="grid-amigos" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
        @foreach($amigos as $amigo)
        <div id="card-amigo-{{ $amigo->id }}" class="bg-white rounded-[40px] shadow-2xl p-8 border-4 border-white hover:border-indigo-100 transition-all group overflow-hidden relative">
            
            {{-- Fondo Decorativo --}}
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>

            <div class="relative flex flex-col items-center">
                <div class="relative mb-6">
                    <img src="{{ $amigo->perfil_foto ? '/' . $amigo->perfil_foto : 'https://ui-avatars.com/api/?name='.urlencode($amigo->name).'&size=128' }}" 
                         class="w-32 h-32 rounded-[35px] object-cover border-4 border-white shadow-xl group-hover:rotate-3 transition-transform">
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 border-4 border-white rounded-full"></div>
                </div>

                <h2 class="text-2xl font-black text-[#32424D] uppercase mb-1">{{ $amigo->name }}</h2>
                <p class="text-[10px] font-bold text-gray-400 mb-8 italic uppercase tracking-widest">Amigo desde {{ $amigo->created_at->format('Y') }}</p>

                <div class="grid grid-cols-1 w-full gap-4">
                    {{-- LLAMAR --}}
                    <a href="tel:{{ $amigo->numero_telefono }}" 
                       class="flex items-center justify-center gap-4 bg-green-500 text-white font-black py-5 rounded-3xl shadow-lg hover:bg-green-600 hover:scale-[1.02] active:scale-95 transition-all text-xl uppercase tracking-widest">
                        <i class="bi bi-telephone-fill"></i> Llamar
                    </a>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- CHATEAR --}}
                        <a href="{{ route('chat.show', $amigo->id) }}"
                           class="flex items-center justify-center gap-2 bg-indigo-500 text-white font-black py-4 rounded-3xl shadow-lg hover:bg-indigo-600 hover:scale-[1.02] active:scale-95 transition-all uppercase tracking-widest text-xs">
                            <i class="bi bi-chat-dots-fill text-lg"></i> Chat
                        </a>

                        {{-- ELIMINAR --}}
                        <button onclick="abrirConfirmacionEliminar('{{ $amigo->id }}', '{{ $amigo->name }}')"
                               class="flex items-center justify-center gap-2 bg-gray-100 text-gray-500 font-black py-4 rounded-3xl hover:bg-red-50 hover:text-red-500 hover:scale-[1.02] active:scale-95 transition-all uppercase tracking-widest text-xs">
                            <i class="bi bi-trash3-fill text-lg"></i> Borrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- MODAL DE CONFIRMACIÓN ÚNICO --}}
<div id="modalConfirmar" class="fixed inset-0 bg-black/70 z-[99999] hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div id="contenidoConfirmar" class="bg-white rounded-[40px] max-w-sm w-full p-8 shadow-2xl transition-all transform scale-95 opacity-0 text-center">
        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="bi bi-person-x-fill text-4xl"></i>
        </div>
        
        <h3 id="titulo-confirmar" class="text-2xl font-black text-gray-800 uppercase leading-tight mb-2">¿Eliminar amigo?</h3>
        <p class="text-gray-400 font-bold mb-8 italic text-xs uppercase tracking-widest">Dejaréis de estar conectados en Tenderete.</p>
        
        {{-- Bloque de acciones --}}
        <div id="acciones-borrar">
            <button onclick="ejecutarBorradoReal()" class="w-full py-4 bg-red-500 text-white rounded-2xl font-black uppercase tracking-widest shadow-lg hover:bg-red-600 transition-all mb-4 active:scale-95">
                Sí, eliminar amigo
            </button>
            <button onclick="cerrarConfirmacion()" class="w-full text-gray-400 font-bold uppercase text-xs hover:text-gray-600 transition-colors">
                No, mantener amistad
            </button>
        </div>

        {{-- Feedback de cargando --}}
        <div id="borrando-loader" class="hidden py-4">
            <div class="animate-spin rounded-full h-10 w-10 border-b-4 border-red-500 mx-auto"></div>
            <p class="mt-4 text-red-500 font-black uppercase text-[10px] tracking-widest">Procesando baja...</p>
        </div>
    </div>
</div>

<script>
    // Variable global de estado
    window.amigoIdParaBorrar = null;

    // 1. ABRIR MODAL
    function abrirConfirmacionEliminar(id, nombre) {
        window.amigoIdParaBorrar = id;
        document.getElementById('titulo-confirmar').innerText = '¿Borrar a ' + nombre + '?';
        
        const m = document.getElementById('modalConfirmar');
        const c = document.getElementById('contenidoConfirmar');
        
        m.classList.remove('hidden');
        setTimeout(() => { 
            c.classList.remove('scale-95', 'opacity-0'); 
            c.classList.add('scale-100', 'opacity-100'); 
        }, 10);
    }

    // 2. CERRAR MODAL
    function cerrarConfirmacion() {
        const c = document.getElementById('contenidoConfirmar');
        c.classList.add('scale-95', 'opacity-0');
        c.classList.remove('scale-100', 'opacity-100');
        
        setTimeout(() => { 
            document.getElementById('modalConfirmar').classList.add('hidden');
            document.getElementById('borrando-loader').classList.add('hidden');
            document.getElementById('acciones-borrar').classList.remove('hidden');
        }, 200);
    }

    // 3. EJECUTAR BORRADO AJAX
    function ejecutarBorradoReal() {
        if (!window.amigoIdParaBorrar) return;

        const acciones = document.getElementById('acciones-borrar');
        const loader = document.getElementById('borrando-loader');

        // UI Feedback
        acciones.classList.add('hidden');
        loader.classList.remove('hidden');

        fetch(`/amigos/${window.amigoIdParaBorrar}/eliminar`, {
            method: 'DELETE',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Error en la red');
            return response.json();
        })
        .then(data => {
            if(data.success) {
                // Seleccionamos la tarjeta del DOM
                const card = document.getElementById('card-amigo-' + window.amigoIdParaBorrar);
                
                // Cerramos el modal inmediatamente
                cerrarConfirmacion();

                // Animación de salida de la tarjeta
                if(card) {
                    card.style.transform = 'scale(0.7) rotate(-5deg)';
                    card.style.opacity = '0';
                    card.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                    
                    setTimeout(() => {
                        card.remove();
                        
                        // Verificamos si el contenedor de amigos está vacío ahora
                        const grid = document.getElementById('grid-amigos');
                        const tarjetasRestantes = document.querySelectorAll('[id^="card-amigo-"]');
                        
                        if (tarjetasRestantes.length === 0) {
                            if(grid) grid.classList.add('hidden');
                            document.getElementById('contenedor-amigos-vacio').classList.remove('hidden');
                        }
                    }, 500);
                }
            } else {
                alert(data.message || 'No se pudo completar la acción.');
                cerrarConfirmacion();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión. Inténtalo de nuevo.');
            cerrarConfirmacion();
        });
    }
</script>

<style>
    /* Suavizamos el movimiento de las tarjetas cuando una desaparece */
    #grid-amigos {
        transition: all 0.5s ease;
    }
    /* Estilo para las tarjetas en proceso de borrado */
    [id^="card-amigo-"] {
        backface-visibility: hidden;
    }
</style>
@endsection