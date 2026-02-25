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
</nav>
@endsection