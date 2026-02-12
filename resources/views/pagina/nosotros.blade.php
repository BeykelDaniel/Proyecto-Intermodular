@extends('layout')

@section('title', 'Inicio')

@section('contenido')

<!-- COLUMNA IZQUIERDA: Video + Banner -->
<div class="md:flex-[3] flex flex-col gap-4">
    <!-- Fila superior: Video y Transcripción -->
    <div class="flex gap-4 bg-white rounded-xl p-4 shadow-sm shrink-0">
        <div class="w-[220px] shrink-0">
            <h4 class="m-0 mb-2 text-[#bc6a50] text-lg font-semibold">Sobre Nosotros</h4>
            <p class="m-0 text-[#3b4d57] text-sm leading-relaxed">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat perferendis quia obcaecati
                tempora odit quam cum porro libero, vitae fugit inventore repellat laboriosam repudiandae
                maiores.
            </p>
        </div>
        <div class="flex-1 overflow-y-auto max-h-[140px]">
            <img src="{{ asset('logo.png') }}" alt="banner"
                class="h-[70px] w-[70px] md:h-[140px] md:w-[140px] rounded-full border-4 border-[#32424D] object-cover shadow-md">
        </div>
    </div>

</div>

@endsection