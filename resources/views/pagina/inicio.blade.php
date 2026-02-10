@extends('layout')

@section('title', 'Inicio')

@section('contenido')
<div class="bg-[#82aeb4] min-h-screen p-4 font-sans flex flex-col items-center gap-4">

    <!-- SECCIÓN SUPERIOR: Video, Banner y Lista -->
    <div class="flex flex-col md:flex-row gap-4 w-full max-w-[1100px] h-auto md:h-[500px] items-stretch">

        <!-- COLUMNA IZQUIERDA: Video + Banner -->
        <div class="md:flex-[3] flex flex-col gap-4">
            <!-- Fila superior: Video y Transcripción -->
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

            <!-- Banner central -->
            <div class="flex-grow rounded-xl overflow-hidden shadow-sm bg-white flex justify-center items-center p-2">
                <img src="{{ asset('banner.png') }}" alt="banner" class="max-w-full max-h-full object-contain block">
            </div>
        </div>

        <!-- COLUMNA DERECHA: Lista de Amigos -->
        <div class="w-full md:w-[240px] bg-white rounded-xl p-4 shadow-sm flex flex-col">
            <h4 class="m-0 mb-3 text-[#bc6a50] text-lg font-semibold border-b border-gray-100 pb-2">
                Añadir Amigos
            </h4>
            <div class="flex-1 overflow-y-auto pr-1 custom-scrollbar">
                <ul class="p-0 m-0 list-none text-[#3b4d57] text-sm">
                    @php
                    // Obtenemos los usuarios excluyendo a Daniel por su email
                    $usuarios_db = \App\Models\User::where('email', '!=', 'cabrerajosedaniel89@gmail.com')
                    ->take(15)
                    ->get();
                    @endphp

                    @forelse($usuarios_db as $u)
                    <li
                        class="mb-3 flex items-center gap-2 border-b border-gray-50 pb-1 hover:bg-gray-50 transition-colors">
                        <span class="text-lg">👤</span> {{ $u->name }}
                    </li>
                    @empty
                    <li class="text-gray-400 italic">No hay otros usuarios disponibles</li>
                    @endforelse

                </ul>
            </div>
        </div>
    </div>

    <div class="w-full max-w-[1100px] bg-white rounded-xl p-6 shadow-sm">
        <h4 class="m-0 mb-4 text-[#bc6a50] text-xl font-bold border-b border-gray-100 pb-3 uppercase">📅 Próximas Actividades</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @php $misIds = auth()->check() ? auth()->user()->actividades->pluck('id')->toArray() : []; @endphp
            @foreach(\App\Models\Actividades::orderBy('fecha', 'asc')->get() as $a)
            <div class="p-4 rounded-xl border border-gray-100 flex flex-col hover:border-[#82aeb4] transition-all">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-black text-gray-800 text-lg uppercase">{{ $a->nombre }}</span>
                    <span class="text-[#bc6a50] font-bold">{{ $a->precio }}€</span>
                </div>
    <div class="flex flex-wrap items-center gap-x-3 text-xs font-bold mb-4 uppercase tracking-wide">
                    <span class="text-[#3b4d57]">📍 {{ $a->lugar }}</span>
                    <span class="text-[#3b4d57] opacity-100">|</span>
                    <span class="text-[#bc6a50]">🗓️ {{ \Carbon\Carbon::parse($a->fecha)->format('d/m/Y') }}</span>
                    <span class="text-[#3b4d57] opacity-100">|</span>
                    <span class="text-[#3b4d57]">🕒 {{ \Carbon\Carbon::parse($a->hora)->format('H:i') }}h</span>
                </div>
                <div class="mt-2 mb-2 flex justify-between items-center font-bold">
                    <span class="text-[10px] text-blue-500 font-bold uppercase">Cupos: {{ $a->cupos }}</span>
                    @if(in_array($a->id, $misIds))
                        <button class="bg-gray-100 text-gray-400 px-4 py-1.5 rounded-lg font-black text-xs uppercase" disabled>Apuntado ✅</button>
                    @else
                        <button id="btn-{{ $a->id }}" onclick="abrirModal({{ json_encode($a) }})" class="bg-[#82aeb4] text-white px-4 py-1.5 rounded-lg font-black text-xs uppercase hover:bg-[#32424D] transition-colors">Ver más</button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div id="modalActividad" class="fixed inset-0 bg-black/60 z-[999] hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-[30px] max-w-sm w-full p-8 shadow-2xl overflow-hidden">
        <div id="modal-form">
            <div id="modal-body" class="text-center"></div>
            <button id="confirmarInscripcion" class="w-full mt-8 py-4 bg-[#bc6a50] text-white rounded-2xl font-black uppercase tracking-widest hover:bg-[#8e4f3c] transition-all">Confirmar Inscripción</button>
            <button onclick="cerrarModal()" class="w-full mt-2 py-2 text-gray-400 font-bold uppercase text-xs">Cancelar</button>
        </div>
        <div id="modal-exito" class="hidden text-center py-6">
            <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="text-2xl font-black text-gray-800 uppercase">¡Todo listo!</h3>
            <p id="exito-msg" class="text-gray-500 text-sm mt-2"></p>
            <button onclick="cerrarModal()" class="mt-8 w-full py-4 bg-[#32424D] text-white rounded-2xl font-black uppercase">Cerrar</button>
        </div>
    </div>
</div>

<script>
    let actSel = null;
    function abrirModal(a) {
        actSel = a;
        document.getElementById('modal-body').innerHTML = `
            <h3 class="text-2xl font-black text-gray-800 uppercase">${a.nombre}</h3>
            <p class="text-gray-400 font-bold mt-2">📍 ${a.lugar}</p>
            <div class="mt-6 bg-gray-50 p-4 rounded-xl border-2 border-dashed border-gray-200">
                <p class="text-[#bc6a50] text-2xl font-black">${a.hora.substring(0,5)}h</p>
            </div>
        `;
        document.getElementById('modal-form').classList.remove('hidden');
        document.getElementById('modal-exito').classList.add('hidden');
        document.getElementById('modalActividad').classList.remove('hidden');
    }
    function cerrarModal() { document.getElementById('modalActividad').classList.add('hidden'); }

    document.getElementById('confirmarInscripcion').onclick = function() {
        this.disabled = true; this.innerText = "PROCESANDO...";
        fetch(`/actividades/${actSel.id}/inscribir`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }})
        .then(r => r.json()).then(data => {
            if(data.success) {
                window.dispatchEvent(new CustomEvent('usuarioInscrito', { detail: { nombre: actSel.nombre, fecha: actSel.fecha }}));
                const bLista = document.getElementById(`btn-${actSel.id}`);
                if(bLista) { bLista.disabled = true; bLista.innerText = "APUNTADO ✅"; bLista.className = "bg-gray-100 text-gray-400 px-4 py-1.5 rounded-lg font-black text-xs uppercase cursor-default"; }
                document.getElementById('exito-msg').innerText = `Te has inscrito en ${actSel.nombre}`;
                document.getElementById('modal-form').classList.add('hidden');
                document.getElementById('modal-exito').classList.remove('hidden');
            }
        });
    };
</script>
@endsection