@extends('layout')

@section('title', 'Inicio')

@section('contenido')

<nav
    class="bg-[#75bac3ff] shadow-md h-24 md:h-28 flex items-center relative border-b-2 border-[#32424D]/10 px-6 md:px-12">
    <div class="w-full flex items-center justify-around">

        <div class="shrink-0">
            <a href="{{ route('pagina.foro') }}" class="block">
                <p>Foro</p>
            </a>
        </div>
        <div class="shrink-0">
            <a href="{{ route('pagina.album') }}" class="block">
                <p>Album</p>
            </a>
        </div>
    </div>
</nav>
<div class="container mt-10 bg-[#ebd08e] rounded-3xl p-8 shadow-xl border border-[#32424D]/10 max-w-6xl mx-auto">
    <!-- Grid con auto-rows para mantener consistencia -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 auto-rows-[300px]">

        <!-- ITEM GRANDE (Ocupa 2 columnas en desktop) -->
        <div
            class="lg:col-span-2 group relative overflow-hidden rounded-2xl bg-gray-100 shadow-sm transition-all hover:shadow-lg">
            <img src="{{ asset('tu-foto-principal.jpg') }}"
                class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
            <div class="absolute bottom-0 left-0 p-4 bg-gradient-to-t from-black/60 to-transparent w-full">
                <p class="text-white font-bold">Destacado</p>
            </div>
        </div>

        <!-- ITEM NORMAL (Cuadrado) -->
        <div class="group relative overflow-hidden rounded-2xl bg-gray-100 shadow-sm transition-all">
            <img src="{{ asset('logo.png') }}"
                class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500">
        </div>

        <!-- ITEM VIDEO -->
        <div class="group relative overflow-hidden rounded-2xl bg-black shadow-sm transition-all">
            <video class="object-cover w-full h-full opacity-80 group-hover:opacity-100 transition-opacity" muted loop
                onmouseover="this.play()" onmouseout="this.pause()">
                <source src="video.mp4" type="video/mp4">
            </video>
            <div class="absolute top-3 right-3 bg-white/20 backdrop-blur-md p-1.5 rounded-full">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.333-5.89a1.5 1.5 0 000-2.538L6.3 2.841z">
                    </path>
                </svg>
            </div>
        </div>

        <!-- Otro item normal -->
        <div class="group relative overflow-hidden rounded-2xl bg-gray-100 shadow-sm transition-all">
            <img src="{{ asset('logo.png') }}"
                class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500">
        </div>

    </div>
</div>



@endsection