@extends('layout')

@section('title', 'Comunidades - Tenderete')

@section('contenido')
<div class="bg-gray-50 min-h-screen">
    
    {{-- CABECERA VIBRANTE --}}
    <div class="bg-[#E8D258] py-16 px-6 border-b-4 border-[#32424D]/10">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-12 text-center md:text-left">
            <div class="shrink-0 w-48 h-48 bg-white/30 rounded-[60px] flex items-center justify-center backdrop-blur-md border-4 border-white shadow-2xl">
                <i class="bi bi-people-fill text-[#32424D] text-8xl"></i>
            </div>
            <div class="flex-1">
                <h1 class="text-6xl font-black text-[#32424D] uppercase tracking-tighter mb-4 leading-none">Tu Comunidad</h1>
                <p class="text-2xl text-[#32424D]/70 font-bold max-w-2xl leading-relaxed">
                    Este es el rincón donde compartimos risas, recuerdos y nuevas experiencias. ¡Únete a la charla!
                </p>
            </div>
        </div>
    </div>

    {{-- ACCIONES PRINCIPALES --}}
    <div class="max-w-6xl mx-auto -mt-10 px-6 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            
            {{-- CARD FORO --}}
            <a href="{{ route('pagina.foro') }}" class="group bg-white rounded-[50px] shadow-2xl p-10 border-4 border-white hover:border-indigo-100 transition-all duration-500 overflow-hidden relative">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-50"></div>
                
                <div class="relative flex flex-col h-full">
                    <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-3xl flex items-center justify-center mb-8 shadow-inner">
                        <i class="bi bi-chat-dots-fill text-4xl"></i>
                    </div>
                    <h2 class="text-4xl font-black text-[#32424D] uppercase mb-4 tracking-tight group-hover:text-indigo-600 transition-colors">Nuestros Foros</h2>
                    <p class="text-xl text-gray-500 font-bold mb-10 leading-relaxed">
                        Habla con tus amigos sobre las actividades pasadas o propón nuevas ideas para el futuro.
                    </p>
                    <div class="mt-auto flex items-center gap-4 text-indigo-600 font-black uppercase tracking-widest text-lg">
                        Entrar a charlar <i class="bi bi-arrow-right-circle-fill text-3xl animate-pulse"></i>
                    </div>
                </div>
            </a>

            {{-- CARD ÁLBUM --}}
            <a href="{{ route('pagina.album') }}" class="group bg-white rounded-[50px] shadow-2xl p-10 border-4 border-white hover:border-pink-100 transition-all duration-500 overflow-hidden relative">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-pink-50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-50"></div>
                
                <div class="relative flex flex-col h-full">
                    <div class="w-20 h-20 bg-pink-100 text-pink-500 rounded-3xl flex items-center justify-center mb-8 shadow-inner">
                        <i class="bi bi-images text-4xl"></i>
                    </div>
                    <h2 class="text-4xl font-black text-[#32424D] uppercase mb-4 tracking-tight group-hover:text-pink-500 transition-colors">Álbum de Fotos</h2>
                    <p class="text-xl text-gray-500 font-bold mb-10 leading-relaxed">
                        Las mejores imágenes de lo que hemos vivido juntos. ¡Recuerda los mejores momentos!
                    </p>
                    <div class="mt-auto flex items-center gap-4 text-pink-500 font-black uppercase tracking-widest text-lg">
                        Ver mis recuerdos <i class="bi bi-heart-fill text-3xl"></i>
                    </div>
                </div>
            </a>

            {{-- SECCIÓN DE ESTADÍSTICAS O RESUMEN LIGERO --}}
            <div class="lg:col-span-2 bg-[#32424D] rounded-[50px] p-12 text-white flex flex-col md:flex-row items-center justify-between gap-10 shadow-2xl">
                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-3xl font-black uppercase mb-2 tracking-widest">¿Necesitas ayuda?</h3>
                    <p class="text-xl font-bold opacity-80 leading-relaxed">Si no encuentras lo que buscas, puedes volver al inicio o preguntar a un amigo.</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('pagina.inicio') }}" class="px-12 py-5 bg-white text-[#32424D] rounded-3xl font-black uppercase tracking-widest shadow-xl hover:scale-105 transition-transform">Inicio</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection