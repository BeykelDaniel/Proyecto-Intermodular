@extends('layout')

@section('title', 'Inicio')

@section('contenido')
<div class="bg-[#C28AED] min-h-screen p-4 font-sans flex flex-col items-center gap-4 rounded-2xl">

    {{-- FILA SUPERIOR --}}
    <div class="flex flex-col md:flex-row gap-4 w-full max-w-[1100px] h-auto md:h-[500px] items-stretch">
        <div class="md:flex-[3] flex flex-col gap-4">
            <div class="flex gap-4 bg-white rounded-xl p-4 shadow-sm shrink-0">
                <div class="w-[220px] shrink-0">
                    <video id="mainVideo" src="{{ asset('vid.mp4') }}" autoplay muted loop controls class="w-full rounded-lg bg-black"></video>
                </div>
                <div class="flex-1 overflow-y-auto max-h-[140px]">
                    <h4 class="m-0 mb-2 text-[#bc6a50] text-lg font-semibold uppercase text-sm italic">Transcripción</h4>
                    <p class="m-0 text-[#3b4d57] text-sm leading-relaxed text-justify italic">
                        "Explora las actividades, añade nuevos amigos y organiza tu calendario sin complicaciones."
                    </p>
                </div>
            </div>
            <div class="flex-grow rounded-xl overflow-hidden shadow-sm bg-white flex justify-center items-center p-2">
                <img src="{{ asset('banner.png') }}" class="w-full h-auto object-contain block rounded-lg">
            </div>
        </div>

        {{-- BARRA LATERAL: AMIGOS --}}
        <div class="w-full md:w-[240px] bg-white rounded-xl p-4 shadow-sm flex flex-col">
            <h4 class="m-0 mb-3 text-[#bc6a50] text-lg font-semibold border-b pb-2 text-center uppercase text-sm">Añadir Amigos</h4>
            <div class="flex-1 overflow-y-auto custom-scrollbar">
                <ul class="list-none p-0 m-0">
                    @php
                        $usuarios_db = \App\Models\User::where('id', '!=', auth()->id())
                            ->where('email', '!=', 'cabrerajosedaniel89@gmail.com')
                            ->latest()->take(12)->get();
                    @endphp
                    @foreach($usuarios_db as $u)
                        <li data-user='@json($u)' 
                            class="abrir-modal-amigo-btn flex items-center gap-3 p-2 hover:bg-indigo-50 rounded-xl cursor-pointer transition-all mb-2 border border-transparent hover:border-indigo-100 group">
                            <div class="w-9 h-9 rounded-full bg-gray-100 flex-shrink-0 border shadow-sm overflow-hidden group-hover:scale-110 transition-transform">
                                @if($u->perfil_foto)
                                    <img src="/{{ $u->perfil_foto }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xl">👤</div>
                                @endif
                            </div>
                            <span class="text-sm font-medium text-gray-700 truncate">{{ $u->name }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- SECCIÓN ACTIVIDADES --}}
    <div class="w-full max-w-[1100px] bg-white rounded-xl p-6 shadow-sm">
        <h4 class="m-0 mb-4 text-gray-800 text-xl font-bold border-b pb-3 uppercase flex items-center gap-2">
            <i class="bi bi-calendar-event text-[#bc6a50]"></i> Próximas Actividades
        </h4>
        <div id="contenedor-actividades" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('actividades.partials.lista')
        </div>

        @auth
        <div class="mt-8">
            <button onclick="window.location.href='{{ route('actividades.create') }}'"
                class="w-full h-24 border-4 border-dashed border-indigo-600 rounded-[35px] text-indigo-600 hover:bg-indigo-50 transition-all flex items-center justify-center gap-4 group">
                <i class="bi bi-plus-circle-fill text-4xl group-hover:scale-110 transition-transform"></i>
                <span class="text-2xl font-black uppercase tracking-widest">Crear Nueva Actividad</span>
            </button>
        </div>
        @endauth

        @if($actividades->hasMorePages())
        <div id="wrapper-btn-cargar" class="flex flex-col items-center mt-10 border-t pt-6">
            <button id="btn-cargar-mas" data-pagina="2" 
                class="bg-[#ecb577] text-white px-10 py-3 rounded-xl font-black uppercase text-xs hover:bg-[#d9a466] shadow-lg transition-all">
                Cargar más actividades
            </button>
        </div>
        @endif
    </div>
</div>

{{-- MODAL GLOBAL REFORMADO --}}
<div id="modalGlobal" class="fixed inset-0 bg-black/70 z-[99999] hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div id="modalContenido" class="bg-white rounded-[40px] max-w-sm w-full p-8 shadow-2xl transition-all transform scale-95 opacity-0">
        
        {{-- PASO 1: FORMULARIO/INFO --}}
        <div id="step-form">
            <div id="modal-dinamico-body" class="text-center">
                {{-- Contenido dinámico --}}
            </div>

            {{-- CONTENEDOR DE ERROR ESTILIZADO (Sustituye al Alert) --}}
            <div id="error-container" class="hidden mt-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center gap-3 animate-pulse">
                <i class="bi bi-exclamation-octagon-fill text-red-500 text-xl"></i>
                <p id="error-msg" class="text-red-700 text-xs font-black uppercase italic"></p>
            </div>

            <button id="btn-confirmar-accion" class="w-full py-4 text-white rounded-2xl font-black uppercase tracking-widest shadow-lg mt-6 active:scale-95 transition-all"></button>
            <button onclick="cerrarModal()" class="w-full mt-4 text-gray-400 font-bold uppercase text-xs hover:text-gray-600 transition-colors">Cancelar</button>
        </div>

        {{-- PASO 2: ÉXITO --}}
        <div id="step-exito" class="hidden text-center py-6">
            <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="text-2xl font-black text-gray-800 uppercase">¡Completado!</h3>
            <p id="msg-exito" class="text-gray-500 text-sm mt-2 italic font-medium"></p>
            <button onclick="cerrarModal()" class="mt-8 w-full py-4 bg-gray-800 text-white rounded-2xl font-black uppercase hover:bg-black transition-all">Cerrar</button>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Variables de Estado
    window.itemSeleccionado = null;
    window.tipoAccion = '';

    // 1. DELEGACIÓN DE EVENTOS (Para botones de amigos y actividades)
    document.addEventListener('click', function(e) {
        // Click en Amigo
        const btnAmigo = e.target.closest('.abrir-modal-amigo-btn');
        if (btnAmigo) {
            const data = JSON.parse(btnAmigo.getAttribute('data-user'));
            abrirModalAmigo(data);
            return;
        }

        // Click en Actividad (Botón Ver Más)
        if (e.target && e.target.classList.contains('btn-ver-mas-act')) {
            const data = JSON.parse(e.target.getAttribute('data-actividad'));
            abrirModalAct(data);
            return;
        }

        // Click en Botón Confirmar Modal
        if (e.target && e.target.id === 'btn-confirmar-accion') {
            enviarServidor(e.target);
        }
    });

    // 2. FUNCIONES DE APERTURA
    function abrirModalAmigo(user) {
        window.itemSeleccionado = user;
        window.tipoAccion = 'amigo';
        
        let edad = 'N/A';
        if(user.fecha_nacimiento) {
            let nac = new Date(user.fecha_nacimiento);
            let hoy = new Date();
            edad = hoy.getFullYear() - nac.getFullYear();
            if (hoy.getMonth() < nac.getMonth() || (hoy.getMonth() === nac.getMonth() && hoy.getDate() < nac.getDate())) edad--;
        }

        const fotoHtml = user.perfil_foto 
            ? `<img src="/${user.perfil_foto}" class="w-24 h-24 rounded-full border-4 border-white shadow-xl object-cover mx-auto">`
            : `<div class="w-24 h-24 bg-gray-100 rounded-full border-4 border-white shadow-xl flex items-center justify-center text-5xl mx-auto">👤</div>`;

        document.getElementById('modal-dinamico-body').innerHTML = `
            ${fotoHtml}
            <h3 class="text-2xl font-black text-[#32424D] uppercase mt-4">${user.name}</h3>
            <div class="grid grid-cols-2 gap-3 mt-6">
                <div class="bg-gray-50 p-4 rounded-2xl border font-bold italic">
                    <p class="text-[10px] text-gray-400 uppercase">Género</p>
                    <p class="text-indigo-600 uppercase text-xs">${user.genero || 'N/A'}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-2xl border font-bold italic">
                    <p class="text-[10px] text-gray-400 uppercase">Edad</p>
                    <p class="text-indigo-600 uppercase text-xs">${edad} AÑOS</p>
                </div>
            </div>
            <p class="mt-4 text-gray-400 font-bold uppercase text-[10px]">¿Enviar solicitud de amistad?</p>
        `;

        const btn = document.getElementById('btn-confirmar-accion');
        btn.innerText = 'ENVIAR SOLICITUD';
        btn.className = "w-full py-4 bg-[#B8A019] text-white rounded-2xl font-black uppercase tracking-widest shadow-lg hover:bg-[#907D14]";
        
        lanzarModal();
    }

    function abrirModalAct(act) {
        window.itemSeleccionado = act;
        window.tipoAccion = 'actividad';
        
        document.getElementById('modal-dinamico-body').innerHTML = `
            <h3 class="text-2xl font-black text-gray-800 uppercase">${act.nombre}</h3>
            <div class="my-6 bg-indigo-50 p-6 rounded-[30px] border-2 border-dashed border-indigo-200">
                <p class="text-indigo-600 font-bold uppercase tracking-widest text-[10px] mb-1">Lugar del evento</p>
                <p class="text-gray-800 font-black italic mb-3">${act.lugar}</p>
                <div class="h-[1px] bg-indigo-100 mb-3"></div>
                <p class="text-indigo-600 font-bold uppercase tracking-widest text-[10px] mb-1">Hora inicio</p>
                <p class="text-3xl font-black text-indigo-700 italic">${act.hora.substring(0,5)}h</p>
            </div>
        `;

        const btn = document.getElementById('btn-confirmar-accion');
        btn.innerText = 'CONFIRMAR ASISTENCIA';
        btn.className = "w-full py-4 bg-[#bc6a50] text-white rounded-2xl font-black uppercase tracking-widest shadow-lg hover:bg-[#8e4f3c]";
        
        lanzarModal();
    }

    // 3. CONTROL VISUAL MODAL
    function lanzarModal() {
        const m = document.getElementById('modalGlobal');
        const c = document.getElementById('modalContenido');
        m.classList.remove('hidden');
        setTimeout(() => { c.classList.remove('scale-95', 'opacity-0'); c.classList.add('scale-100', 'opacity-100'); }, 10);
    }

    window.cerrarModal = function() {
        const c = document.getElementById('modalContenido');
        c.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { 
            document.getElementById('modalGlobal').classList.add('hidden'); 
            document.getElementById('step-form').classList.remove('hidden');
            document.getElementById('step-exito').classList.add('hidden');
            document.getElementById('error-container').classList.add('hidden');
        }, 200);
    }

    // 4. LÓGICA DE SERVIDOR (AJAX + FEEDBACK)
    function enviarServidor(btn) {
        const errContainer = document.getElementById('error-container');
        errContainer.classList.add('hidden');
        
        btn.disabled = true;
        btn.innerText = 'PROCESANDO...';

        const url = window.tipoAccion === 'amigo' 
            ? `/amigos/${window.itemSeleccionado.id}/solicitar` 
            : `/actividades/${window.itemSeleccionado.id}/inscribir`;

        fetch(url, {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                document.getElementById('step-form').classList.add('hidden');
                document.getElementById('step-exito').classList.remove('hidden');
                document.getElementById('msg-exito').innerText = data.message || "Operación realizada correctamente";

                // Reactividad en la lista
                if(window.tipoAccion === 'actividad') {
                    const selector = `[data-actividad*='"id":${window.itemSeleccionado.id}']`;
                    const bOriginal = document.querySelector(selector);
                    if(bOriginal) {
                        bOriginal.disabled = true;
                        bOriginal.innerText = '¡APUNTADO!';
                        bOriginal.className = "bg-gray-100 text-gray-400 px-4 py-1.5 rounded-lg font-black text-xs uppercase cursor-default shadow-none border-none";
                        bOriginal.classList.remove('btn-ver-mas-act');
                    }
                }
            } else {
                // FORMATO ERROR ESTILIZADO
                errContainer.classList.remove('hidden');
                document.getElementById('error-msg').innerText = data.message || "Error al procesar la solicitud";
                
                // Efecto de vibración al contenido
                const c = document.getElementById('modalContenido');
                c.classList.add('animate-shake');
                setTimeout(() => c.classList.remove('animate-shake'), 400);

                btn.disabled = false;
                btn.innerText = 'REINTENTAR';
            }
        })
        .catch(err => {
            errContainer.classList.remove('hidden');
            document.getElementById('error-msg').innerText = "Fallo de conexión con el servidor";
            btn.disabled = false;
            btn.innerText = 'ERROR';
        });
    }

    // 5. CARGAR MÁS (SCROLL INFINITO)
    $(document).ready(function() {
        $('#btn-cargar-mas').on('click', function() {
            let btn = $(this);
            let pagina = btn.data('pagina');
            btn.prop('disabled', true).text('BUSCANDO MÁS...');
            
            $.get("?page=" + pagina, function(data) {
                if(data.trim()) {
                    $("#contenedor-actividades").append(data);
                    btn.data('pagina', pagina + 1).prop('disabled', false).text('Cargar más actividades');
                } else { btn.hide(); }
            });
        });
    });
</script>

<style>
/* Animación Shake para errores */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-8px); }
    50% { transform: translateX(8px); }
    75% { transform: translateX(-8px); }
}
.animate-shake { animation: shake 0.4s cubic-bezier(.36,.07,.19,.97) both; }
</style>
@endsection