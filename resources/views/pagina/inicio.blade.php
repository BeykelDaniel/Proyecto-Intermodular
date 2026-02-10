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

    <!-- SECCIÓN INFERIOR: Actividades -->
    <div class="w-full max-w-[1100px] bg-white rounded-xl p-4 shadow-sm">
        <h4 class="m-0 mb-3 text-[#bc6a50] text-lg font-semibold border-b border-gray-100 pb-2">Actividades</h4>
        <p class="text-[#82aeb4] text-sm">Aquí puedes listar las actividades recientes...</p>
    </div>

    <!-- SECCIÓN INFERIOR: Álbumes -->
    <div class="w-full max-w-[1100px] bg-white rounded-xl p-4 shadow-sm">
        <h4 class="m-0 mb-3 text-[#bc6a50] text-lg font-semibold border-b border-gray-100 pb-2">Álbumes</h4>
        <p class="text-[#82aeb4] text-sm">Explora tus álbumes de fotos...</p>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const video = document.getElementById('mainVideo');
        if (video) {
            video.play().catch(() => {
                video.muted = true;
                video.play();
            });
        }
    });
</script>
@endpush
@endsection