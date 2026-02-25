@extends('layout')

@section('title', isset($actividad) ? 'Foro: ' . $actividad->nombre : 'Foros de Actividades')

@section('contenido')
<div class="bg-gray-50 min-h-screen p-6 font-sans">
    <div class="max-w-4xl mx-auto">
        @if(isset($actividad))
        <div class="flex items-center gap-4 mb-8 bg-white p-6 rounded-3xl shadow-sm">
            @if($actividad->imagen)
                <img src="{{ asset($actividad->imagen) }}" class="w-16 h-16 rounded-2xl object-cover shadow-sm">
            @endif
            <div>
                <h2 class="text-3xl font-black text-gray-800 uppercase">{{ $actividad->nombre }}</h2>
                <div class="flex gap-4">
                    <p class="text-gray-400 font-bold uppercase text-xs tracking-widest"><i class="bi bi-chat-dots-fill text-indigo-500 mr-1"></i> Foro de Discusión</p>
                    <a href="{{ route('actividades.album', $actividad->id) }}" class="text-pink-500 font-bold uppercase text-xs tracking-widest hover:underline"><i class="bi bi-images mr-1"></i> Ver Álbum</a>
                </div>
            </div>
            <a href="{{ route('pagina.foro') }}" class="ml-auto px-6 py-3 bg-gray-100 text-gray-600 rounded-2xl font-black uppercase text-xs hover:bg-gray-200 transition-all shadow-sm">Todos los foros</a>
        </div>
        
        {{-- SUB NAVBAR SENIOR --}}
        <div class="flex justify-center mb-10">
            <nav class="flex gap-4 bg-white p-2 rounded-[30px] shadow-sm border border-gray-100">
                <a href="{{ route('actividades.foro', $actividad->id) }}" 
                   class="flex items-center gap-4 px-10 py-5 rounded-[25px] text-lg font-black uppercase tracking-widest transition-all {{ request()->routeIs('actividades.foro') ? 'bg-indigo-600 text-white shadow-xl' : 'text-gray-400 hover:bg-gray-50' }}">
                    <i class="bi bi-chat-dots-fill text-2xl"></i> Foro
                </a>
                <a href="{{ route('actividades.album', $actividad->id) }}" 
                   class="flex items-center gap-4 px-10 py-5 rounded-[25px] text-lg font-black uppercase tracking-widest transition-all {{ request()->routeIs('actividades.album') ? 'bg-pink-500 text-white shadow-xl' : 'text-gray-400 hover:bg-gray-50' }}">
                    <i class="bi bi-images text-2xl"></i> Álbum
                </a>
            </nav>
        </div>
        @else
        <div class="mb-8 bg-white p-10 rounded-[40px] shadow-sm text-center border-b-8 border-indigo-600">
            <h2 class="text-4xl font-black text-gray-800 uppercase mb-2">Mis Foros</h2>
            <p class="text-gray-400 font-bold uppercase text-sm tracking-widest">Charla con tus compañeros de actividades</p>
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($actividades as $act)
            <a href="{{ route('actividades.foro', $act->id) }}" class="group bg-white p-6 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-transparent hover:border-indigo-100 flex items-center gap-6">
                <div class="w-20 h-20 shrink-0 rounded-2xl overflow-hidden shadow-md">
                    @if($act->imagen)
                        <img src="{{ asset($act->imagen) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-indigo-50 flex items-center justify-center text-indigo-300">
                            <i class="bi bi-chat-dots-fill text-3xl"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h4 class="text-xl font-black text-gray-800 uppercase group-hover:text-indigo-600 transition-colors">{{ $act->nombre }}</h4>
                    <p class="text-gray-400 text-sm font-bold uppercase tracking-widest">{{ $act->posts_count }} mensajes publicados</p>
                </div>
                <i class="bi bi-chevron-right text-gray-200 group-hover:text-indigo-300 transition-all text-2xl"></i>
            </a>
            @empty
            <div class="col-span-full bg-white p-16 rounded-[40px] text-center shadow-sm border border-gray-100">
                <i class="bi bi-chat-square-dots text-6xl text-gray-100 mb-6 block"></i>
                <p class="text-gray-400 font-bold uppercase tracking-widest mb-4">Aún no estás inscrito en ninguna actividad.</p>
                <a href="{{ route('pagina.inicio') }}" class="inline-block bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black uppercase text-xs hover:bg-indigo-700 transition-all shadow-lg">Ver Actividades Disponibles</a>
            </div>
            @endforelse
        </div>
        @endif

        @if(isset($actividad))
        <!-- Componente Foro Vue -->
        <foro-actividad 
            initial-mensajes="{{ json_encode($actividad->posts->map(fn($p) => array_merge($p->toArray(), ['user' => $p->user->toArray()]))) }}"
            current-user-id="{{ auth()->id() }}"
            route-store="{{ route('actividades.foro.post', $actividad->id) }}"
            route-nuevos="{{ route('actividades.foro.nuevos', $actividad->id) }}"
            csrf="{{ csrf_token() }}">
        </foro-actividad>
@endif
    </div>
</div>
    </div>
</div>
@endsection