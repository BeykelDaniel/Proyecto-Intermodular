@extends('layout')

@section('title', 'Inicio')

@section('contenido')
<div class="bg-[#C28AED] min-h-screen p-4 font-sans flex flex-col items-center gap-4 rounded-2xl">

    <div class="flex flex-col md:flex-row gap-4 w-full max-w-[1100px] h-auto md:h-[500px] items-stretch">

        <div class="md:flex-[3] flex flex-col gap-4">
            <div class="flex gap-4 bg-white rounded-xl p-4 shadow-sm shrink-0">
                <div class="w-[220px] shrink-0">
                    <video id="mainVideo" src="{{ asset('vid.mp4') }}" autoplay muted loop controls
                        class="w-full rounded-lg bg-black"></video>
                </div>
                <div class="flex-1 overflow-y-auto max-h-[140px]">
                    <h4 class="m-0 mb-2 text-[#bc6a50] text-lg font-semibold">Transcripción</h4>
                    <p class="m-0 text-[#3b4d57] text-sm leading-relaxed">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat perferendis quia obcaecati
                        tempora odit quam cum porro libero, vitae fugit inventore repellat laboriosam repudiandae
                        maiores.
                    </p>
                </div>
            </div>

            <div class="flex-grow rounded-xl overflow-hidden shadow-sm bg-white flex justify-center items-center p-2">
                <img src="{{ asset('banner.png') }}" alt="banner" class="w-full h-auto object-contain block rounded-lg">
            </div>
        </div>
        <div class="w-full md:w-[240px] bg-white rounded-xl p-4 shadow-sm flex flex-col">
            <div class="flex justify-between items-center mb-3 border-b border-gray-100 pb-2">
                <h4 class="m-0 text-[#bc6a50] text-lg font-semibold">
                    Añadir Amigos
                </h4>

            </div>
            <div class="flex-1 overflow-y-auto pr-1 custom-scrollbar">
                <ul class="p-0 m-0 list-none text-[#3b4d57] text-sm">
                    @php
                    $usuarios_db = \App\Models\User::where('email', '!=', 'cabrerajosedaniel89@gmail.com')
                    ->latest()
                    ->take(15)
                    ->get();
                    @endphp

                    @forelse($usuarios_db as $u)
                    {{-- Se repite por cada amigo encontrado --}}
                    <li onclick="abrirModalAñadirAmigo({{ $u->toJson() }})"
                        class="flex items-center gap-2 p-2 hover:bg-gray-50 rounded-lg cursor-pointer transition-colors mb-1">
                        @if($u->perfil_foto)
                            <img src="{{ asset($u->perfil_foto) }}" alt="{{ $u->name }}" class="w-8 h-8 rounded-full object-cover shadow-sm">
                        @else
                            <span class="text-lg">👤</span>
                        @endif
                         {{ $u->name }}
                    </li>
                    @empty
                    {{-- Esto sale solo si la base de datos no devuelve usuarios --}}
                    <li class="text-gray-400 italic p-2">No hay otros usuarios disponibles</li>
                    @endforelse
                </ul>
            </div>
        </div>


    </div>

    <div class="w-full max-w-[1100px] bg-white rounded-xl p-6 shadow-sm">
        <h4 class="m-0 mb-4 text-gray-800 text-xl font-bold border-b border-gray-100 pb-3 uppercase">
            <i class="bi bi-calendar-fill bg-[#bc6a50] text-white rounded-full p-2"></i> Próximas Actividades
        </h4>
        <div id="contenedor-actividades" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('actividades.partials.lista')

            {{-- NO SACA MI USUARIO -> ADMIN --}}
        @auth
        <div class="flex items-center justify-center col-span-full mt-4">
            <button type="button" onclick="window.location.href='{{ route('actividades.create') }}'"
                class="group flex items-center justify-center w-full h-24 bg-white border-4 border-solid border-indigo-600 rounded-[35px] hover:bg-indigo-50 transition-all duration-300 shadow-xl">
                <i class="bi bi-plus-circle-fill text-4xl text-indigo-600 mr-6 group-hover:scale-110 transition-transform"></i>
                <span class="text-2xl font-black uppercase text-indigo-600 tracking-widest">Crear Nueva Actividad</span>
            </button>
        </div>
        @endauth
        </div>

        @if($actividades->hasMorePages())
        <div id="wrapper-btn-cargar" class="flex flex-col items-center mt-8 gap-2">
            @php
            $restantes = $actividades->total() - ($actividades->currentPage() * $actividades->perPage());
            @endphp
            <p id="texto-restantes" class="text-black text-s font-bold uppercase tracking-widest">
                Quedan <span id="num-restantes" class=" text-[#1C31B5]">{{ $restantes > 0 ? $restantes : 0 }}</span>
                actividades
                por ver
            </p>

            <button id="btn-cargar-mas" data-pagina="2" data-total="{{ $actividades->total() }}"
                data-perpage="{{ $actividades->perPage() }}"
                class="bg-[#ecb577] text-white px-8 py-2.5 rounded-lg font-black text-xs uppercase hover:bg-[#d9a466] transition-all shadow-md">
                Más Actividades
            </button>
        </div>
        @endif
    </div>
    <div class="w-full max-w-[1100px] bg-white rounded-xl p-6 shadow-sm">
        <h4 class="m-0 mb-4 text-gray-800 text-xl font-bold border-b border-gray-100 pb-3 uppercase">
            <i class="bi bi-images bg-[#bc6a50] text-white rounded-full p-2"></i> Mis Álbumes
        </h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($mis_actividades as $ma)
            <div class="flex flex-col gap-2 p-2 border border-gray-100 rounded-xl hover:shadow-md transition-all cursor-pointer" 
                 onclick="window.location.href='{{ route('actividades.album', $ma->id) }}'">
                <div class="h-24 w-full bg-gray-100 rounded-lg overflow-hidden">
                    @if($ma->imagen)
                        <img src="{{ asset($ma->imagen) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <i class="bi bi-images text-2xl"></i>
                        </div>
                    @endif
                </div>
                <span class="text-xs font-bold text-center uppercase truncate">{{ $ma->nombre }}</span>
            </div>
            @empty
            <p class="text-gray-400 italic text-sm">Aún no tienes álbumes de actividades.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- MODAL INSCRIPCIÓN ACTIVIDAD --}}
<div id="modalActividad"
    class="fixed inset-0 bg-black/60 z-[999] hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-[30px] max-w-sm w-full p-8 shadow-2xl">
        <div id="act-form-content">
            <div id="modal-body" class="text-center"></div>
            <button id="confirmarInscripcion"
                class="w-full mt-8 py-4 bg-[#bc6a50] text-white rounded-2xl font-black uppercase tracking-widest hover:bg-[#8e4f3c] transition-all shadow-lg">
                Confirmar Inscripción
            </button>
            <button onclick="cerrarModal('modalActividad')"
                class="w-full mt-2 py-2 text-gray-400 font-bold uppercase text-xs">Cancelar</button>
        </div>
        <div id="act-exito-content" class="hidden text-center py-6">
            <div
                class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-gray-800 uppercase">¡Registrado!</h3>
            <p id="exito-msg-act" class="text-gray-500 text-sm mt-2"></p>
            <button onclick="cerrarModal('modalActividad')"
                class="mt-8 w-full py-4 bg-[#32424D] text-white rounded-2xl font-black uppercase">Cerrar</button>
        </div>
    </div>
</div>

{{-- MODAL AÑADIR AMIGO --}}
<div id="ModalAñadirAmigo"
    class="fixed inset-0 bg-black/60 z-[999] hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-[30px] max-w-sm w-full p-8 shadow-2xl">
        <div id="amigo-form-content">
            <div id="modal-amigo-body" class="text-center"></div>
            <button id="confirmarAñadirAmigo"
                class="w-full mt-8 py-4 bg-[#B8A019] text-white rounded-2xl font-black uppercase tracking-widest hover:bg-[#907D14] transition-all shadow-lg">
                Enviar Solicitud
            </button>
            <button onclick="cerrarModal('ModalAñadirAmigo')"
                class="w-full mt-2 py-2 text-gray-400 font-bold uppercase text-xs">Cancelar</button>
        </div>
        <div id="amigo-exito-content" class="hidden text-center py-6">
            <div
                class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-gray-800 uppercase">¡Genial!</h3>
            <p id="exito-msg-amigo" class="text-gray-500 text-sm mt-2"></p>
            <button onclick="cerrarModal('ModalAñadirAmigo')"
                class="mt-8 w-full py-4 bg-[#32424D] text-white rounded-2xl font-black uppercase">Cerrar</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let actSel = null;
    let amigoSel = null;

    // --- UTILIDADES ---
    function limpiarTexto(texto) {
        return texto ? texto.trim().replace(/\s+/g, ' ') : "";
    }

    function mostrarFormulario(tipo) {
        document.getElementById(`${tipo}-form-content`).classList.remove('hidden');
        document.getElementById(`${tipo}-exito-content`).classList.add('hidden');
    }

    function cerrarModal(id) { document.getElementById(id).classList.add('hidden'); }

    // --- LÓGICA DE ACTIVIDADES ---
    function abrirModal(a) {
        actSel = a;
        document.getElementById('modal-body').innerHTML = `
            <h3 class="text-2xl font-black text-gray-800 uppercase">${limpiarTexto(a.nombre)}</h3>
            ${a.imagen ? `<div class="mt-4 rounded-2xl overflow-hidden h-40 w-full"><img src="/${a.imagen}" class="w-full h-full object-cover"></div>` : ''}
            <p class="text-gray-400 font-bold mt-2"> <i class="bi bi-geo-fill text-[#bc6a50]"></i> ${limpiarTexto(a.lugar)}</p>
            <div class="mt-6 bg-gray-50 p-4 rounded-xl border-2 border-dashed border-gray-200">
                <p class="text-[#bc6a50] text-2xl font-black">${a.hora.substring(0, 5)}h</p>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-2">
                <a href="/actividades/${a.id}/foro" class="flex items-center justify-center gap-2 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold uppercase text-xs hover:bg-indigo-100 transition-all">
                    <i class="bi bi-chat-dots-fill"></i> Foro
                </a>
                <a href="/actividades/${a.id}/album" class="flex items-center justify-center gap-2 py-2 bg-pink-50 text-pink-600 rounded-xl font-bold uppercase text-xs hover:bg-pink-100 transition-all">
                    <i class="bi bi-images"></i> Álbum
                </a>
            </div>`;
        mostrarFormulario('act');
        document.getElementById('modalActividad').classList.remove('hidden');
    }

    document.getElementById('confirmarInscripcion').onclick = function () {
        ejecutarPost(`/actividades/${actSel.id}/inscribir`, 'act', `Te has inscrito en ${actSel.nombre}`);
    };

    // --- LÓGICA DE AMIGOS ---
    function abrirModalAñadirAmigo(u) {
        amigoSel = u;
        const nombreLimpio = limpiarTexto(u.name);
        const genero = u.genero || 'No especificado';
        // Formateo de fecha para evitar los ceros del ISO
        const fechaNac = u.fecha_nacimiento ? u.fecha_nacimiento.split('T')[0] : 'No disponible';
        const icono = (genero.toLowerCase() === 'mujer') ? '👩' : '👨';

        const fotoHtml = u.perfil_foto 
            ? `<img src="/${u.perfil_foto}" class="w-24 h-24 rounded-full border-4 border-white shadow-md object-cover">`
            : `<div class="w-24 h-24 bg-gray-100 rounded-full border-4 border-white shadow-md flex items-center justify-center text-5xl shrink-0">${icono}</div>`;

        document.getElementById('modal-amigo-body').innerHTML = `
            <div class="flex justify-center mb-4">
                ${fotoHtml}
            </div>
            <h3 class="text-2xl font-black text-gray-800 uppercase">${nombreLimpio}</h3>
            <div class="grid grid-cols-2 gap-2 mt-4 bg-gray-50 p-3 rounded-2xl border border-gray-100 text-center">
                <div>
                    <p class="text-lg font-black text-[#3B51E0] uppercase">Género</p>
                    <p class="text-xl font-bold text-[#8A63F6]">${genero}</p>
                </div>
                <div class="border-l border-gray-200">
                    <p class="text-lg font-black text-[#3B51E0] uppercase">Nacimiento</p>
                    <p class="text-xl font-bold text-[#8A63F6]">${fechaNac}</p>
                </div>
            </div>
            <p class="text-black font-bold mt-6 text-lg">¿Quieres enviar una solicitud de amistad?</p>`;

        mostrarFormulario('amigo');
        document.getElementById('ModalAñadirAmigo').classList.remove('hidden');
    }

    document.getElementById('confirmarAñadirAmigo').onclick = function () {
        ejecutarPost(`/amigos/${amigoSel.id}/solicitar`, 'amigo', `Solicitud enviada a ${amigoSel.name}`);
    };

    // --- EJECUCIÓN POST AJAX ---
    function ejecutarPost(url, tipo, msgExito) {
        const btn = tipo === 'act' ? document.getElementById('confirmarInscripcion') : document.getElementById('confirmarAñadirAmigo');
        const textoOriginal = btn.innerText;

        btn.disabled = true;
        btn.innerText = "PROCESANDO...";

        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`exito-msg-${tipo}`).innerText = msgExito;
                    document.getElementById(`${tipo}-form-content`).classList.add('hidden');
                    document.getElementById(`${tipo}-exito-content`).classList.remove('hidden');

                    if (tipo === 'act') {
                        const bLista = document.getElementById(`btn-${actSel.id}`);
                        if (bLista) {
                            bLista.disabled = true;
                            bLista.innerText = "¡Apuntado!";
                            bLista.className = "bg-gray-100 text-gray-400 px-4 py-1.5 rounded-lg font-black text-xs uppercase cursor-default";
                        }
                    }
                } else {
                    alert(data.message || "Error al procesar la solicitud");
                }
            })
            .catch(err => console.error(err))
            .finally(() => {
                btn.disabled = false;
                btn.innerText = textoOriginal;
            });
    }

    // --- CARGA INFINITA ---
    $(document).ready(function () {
        $('#btn-cargar-mas').on('click', function () {
            let btn = $(this);
            let pagina = btn.data('pagina');
            let total = btn.data('total');
            let perPage = btn.data('perpage');

            $.ajax({
                url: "?page=" + pagina,
                type: "get",
                beforeSend: function () {
                    btn.text('Cargando...');
                    btn.prop('disabled', true);
                }
            })
                .done(function (data) {
                    if (data.trim().length == 0) {
                        $('#wrapper-btn-cargar').html('<p class="text-gray-400 text-xs font-bold uppercase">No hay más actividades</p>');
                        return;
                    }
                    $("#contenedor-actividades").append(data);
                    let cargadas = pagina * perPage;
                    let quedan = total - cargadas;
                    if (quedan <= 0) {
                        $('#wrapper-btn-cargar').html('<p class="text-gray-400 text-xs font-bold uppercase">¡Has visto todo!</p>');
                    } else {
                        $('#num-restantes').text(quedan);
                        btn.data('pagina', pagina + 1).text('Más Actividades').prop('disabled', false);
                    }
                });
        });
    });
</script>
@endsection