@extends('layout')

@section('title', 'Inicio')

@section('contenido')
<div class="bg-[#82aeb4] min-h-screen p-4 font-sans flex flex-col items-center gap-4">

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
                <img src="{{ asset('banner.png') }}" alt="banner" class="max-w-full max-h-full object-contain block">
            </div>
        </div>

        <div class="w-full md:w-[240px] bg-white rounded-xl p-4 shadow-sm flex flex-col">
            <h4 class="m-0 mb-3 text-[#bc6a50] text-lg font-semibold border-b border-gray-100 pb-2">
                Añadir Amigos
            </h4>
            <div class="flex-1 overflow-y-auto pr-1 custom-scrollbar">
                <ul class="p-0 m-0 list-none text-[#3b4d57] text-sm">
                    @php
                    $usuarios_db = \App\Models\User::where('email', '!=', 'cabrerajosedaniel89@gmail.com')
                    ->take(15)
                    ->get();
                    @endphp

                    @forelse($usuarios_db as $u)
                    <li onclick="abrirModalAñadirAmigo({{ json_encode(['id' => $u->id, 'name' => $u->name]) }})"
                        class="mb-3 flex items-center gap-2 border-b border-gray-50 pb-1 hover:bg-gray-50 transition-colors cursor-pointer p-1 rounded-md">
                        <span class="text-lg">👤</span> {{ $u->name }}
                    </li>
                    @empty
                    <li class="text-gray-400 italic p-2">No hay otros usuarios disponibles</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="w-full max-w-[1100px] bg-white rounded-xl p-6 shadow-sm">
        <h4 class="m-0 mb-4 text-gray-800 text-xl font-bold border-b border-gray-100 pb-3 uppercase">
            <i class="bi bi-calendar-fill text-[#bc6a50]"></i> Próximas Actividades
        </h4>

        <div id="contenedor-actividades" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('actividades.partials.lista')
        </div>

        @if($actividades->hasMorePages())
        <div id="wrapper-btn-cargar" class="flex flex-col items-center mt-8 gap-2">
            @php
            $restantes = $actividades->total() - ($actividades->currentPage() * $actividades->perPage());
            @endphp
            <p id="texto-restantes" class="text-gray-400 text-xs font-bold uppercase tracking-widest">
                Quedan <span id="num-restantes">{{ $restantes > 0 ? $restantes : 0 }}</span> actividades por ver
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
            <i class="bi bi-images text-[#bc6a50]"></i> Mis Álbumes
        </h4>
    </div>
</div>

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

<div id="ModalAñadirAmigo"
    class="fixed inset-0 bg-black/60 z-[999] hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-[30px] max-w-sm w-full p-8 shadow-2xl">
        <div id="amigo-form-content">
            <div id="modal-amigo-body" class="text-center"></div>
            <button id="confirmarAñadirAmigo"
                class="w-full mt-8 py-4 bg-[#bc6a50] text-white rounded-2xl font-black uppercase tracking-widest hover:bg-[#8e4f3c] transition-all shadow-lg">
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

    // --- LÓGICA DE ACTIVIDADES ---
    function abrirModal(a) {
        actSel = a;
        document.getElementById('modal-body').innerHTML = `
            <h3 class="text-2xl font-black text-gray-800 uppercase">${a.nombre}</h3>
            <p class="text-gray-400 font-bold mt-2"> <i class="bi bi-geo-fill text-[#bc6a50]"></i> ${a.lugar}</p>
            <div class="mt-6 bg-gray-50 p-4 rounded-xl border-2 border-dashed border-gray-200">
                <p class="text-[#bc6a50] text-2xl font-black">${a.hora.substring(0, 5)}h</p>
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
        document.getElementById('modal-amigo-body').innerHTML = `
            <h3 class="text-2xl font-black text-gray-800 uppercase">${u.name}</h3>
            <p class="text-gray-400 font-bold mt-2">¿Quieres añadir a esta persona a tu red de amigos?</p>`;
        mostrarFormulario('amigo');
        document.getElementById('ModalAñadirAmigo').classList.remove('hidden');
    }

    document.getElementById('confirmarAñadirAmigo').onclick = function () {
        ejecutarPost(`/amigos/${amigoSel.id}/añadir`, 'amigo', `Solicitud enviada a ${amigoSel.name}`);
    };

    // --- FUNCIONES AUXILIARES ---
    function mostrarFormulario(tipo) {
        document.getElementById(`${tipo}-form-content`).classList.remove('hidden');
        document.getElementById(`${tipo}-exito-content`).classList.add('hidden');
    }

    function cerrarModal(id) { document.getElementById(id).classList.add('hidden'); }

    function ejecutarPost(url, tipo, msgExito) {
        const btn = tipo === 'act' ? document.getElementById('confirmarInscripcion') : document.getElementById('confirmarAñadirAmigo');
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

                    // Si es actividad, actualizar el botón de la lista principal
                    if (tipo === 'act') {
                        const bLista = document.getElementById(`btn-${actSel.id}`);
                        if (bLista) {
                            bLista.disabled = true; bLista.innerText = "¡Apuntado!";
                            bLista.className = "bg-gray-100 text-gray-400 px-4 py-1.5 rounded-lg font-black text-xs uppercase cursor-default";
                        }
                    }
                }
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerText = tipo === 'act' ? "Confirmar Inscripción" : "Enviar Solicitud";
            });
    }

    // --- LÓGICA DE CARGA INFINITA CON CONTADOR ---
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

                    // Actualizar contador
                    let cargadas = pagina * perPage;
                    let quedan = total - cargadas;

                    if (quedan <= 0) {
                        $('#wrapper-btn-cargar').html('<p class="text-gray-400 text-xs font-bold uppercase">¡Has visto todas las actividades!</p>');
                    } else {
                        $('#num-restantes').text(quedan);
                        btn.data('pagina', pagina + 1).text('Más Actividades').prop('disabled', false);
                    }
                });
        });
    });
</script>
@endsection