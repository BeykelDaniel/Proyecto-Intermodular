@extends('layout')

@section('title', 'Álbumes de Actividades')

@section('contenido')
<div class="bg-gray-50 min-h-screen p-6 font-sans">
    <div class="max-w-6xl mx-auto">
        <div class="mb-10 bg-white p-12 rounded-[40px] shadow-sm text-center border-b-8 border-pink-500">
            <h2 class="text-4xl font-black text-gray-800 uppercase mb-2">Mis Álbumes</h2>
            <p class="text-gray-400 font-bold uppercase text-sm tracking-widest">Los recuerdos de tus actividades favoritas</p>
        </div>

        {{-- SUB NAVBAR SENIOR --}}
        <div class="flex justify-center mb-10">
            <nav class="flex gap-4 bg-white p-2 rounded-[30px] shadow-sm border border-gray-100">
                <a href="{{ route('pagina.foro') }}" 
                   class="flex items-center gap-4 px-10 py-5 rounded-[25px] text-lg font-black uppercase tracking-widest transition-all {{ request()->routeIs('pagina.foro') ? 'bg-indigo-600 text-white shadow-xl' : 'text-gray-400 hover:bg-gray-50' }}">
                    <i class="bi bi-chat-dots-fill text-2xl"></i> Foros
                </a>
                <a href="{{ route('pagina.album') }}" 
                   class="flex items-center gap-4 px-10 py-5 rounded-[25px] text-lg font-black uppercase tracking-widest transition-all {{ request()->routeIs('pagina.album') ? 'bg-pink-500 text-white shadow-xl' : 'text-gray-400 hover:bg-gray-50' }}">
                    <i class="bi bi-images text-2xl"></i> Álbumes
                </a>
            </nav>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($actividades as $act)
            <div onclick="window.location.href='{{ route('actividades.album', $act->id) }}'" 
                 class="group bg-white rounded-[35px] overflow-hidden shadow-sm hover:shadow-2xl transition-all cursor-pointer border border-transparent hover:border-pink-100 flex flex-col">
                
                <div class="h-48 w-full bg-gray-100 overflow-hidden relative">
                    @if($act->imagen)
                        <img src="{{ asset($act->imagen) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-pink-200">
                            <i class="bi bi-images text-5xl"></i>
                        </div>
                    @endif
                    <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-1 rounded-full shadow-sm">
                        <span class="text-xs font-black text-pink-600 uppercase">{{ $act->media_count }} ARCHIVOS</span>
                    </div>
                </div>

                <div class="p-6">
                    <h4 class="text-xl font-black text-gray-800 uppercase group-hover:text-pink-600 transition-colors">{{ $act->nombre }}</h4>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">
                        <i class="bi bi-calendar-event mr-1"></i> {{ \Carbon\Carbon::parse($act->fecha)->format('d/m/Y') }}
                    </p>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white p-16 rounded-[40px] text-center shadow-sm border border-gray-100">
                <i class="bi bi-images text-6xl text-gray-100 mb-6 block"></i>
                <p class="text-gray-400 font-bold uppercase tracking-widest mb-4">Aún no tienes álbumes disponibles.</p>
                <p class="text-gray-400 text-sm mb-6 uppercase font-bold">Inscríbete en una actividad para empezar a compartir recuerdos.</p>
                <a href="{{ route('pagina.inicio') }}" class="inline-block bg-pink-500 text-white px-8 py-4 rounded-2xl font-black uppercase text-xs hover:bg-pink-600 transition-all shadow-lg">Buscar Actividades</a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection