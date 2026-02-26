@extends('layouts.landing')

@section('title', 'Bienvenido a Tenderete')

@section('contenido')
<div class="space-y-24 pb-20">

    <div id="app">
        <carrousel-home 
            login-route="{{ route('pagina.login_usuarios') }}" 
            banner-img="{{ asset('banner.png') }}" 
            logo-img="{{ asset('logo.png') }}" 
            storage-img="{{ asset('banner.png') }}">
        </carrousel-home>
    </div>

    <section id="servicios" class="grid md:grid-cols-3 gap-12">
        <div class="bg-white p-10 rounded-[40px] border-4 border-gray-100 shadow-md hover:border-[#E8D258] transition-colors text-center">
            <div class="w-24 h-24 bg-[#F1E498] rounded-3xl flex items-center justify-center mb-8 mx-auto">
                <i class="bi bi-people-fill text-5xl text-[#32424D]"></i>
            </div>
            <h3 class="text-4xl font-black text-[#32424D] mb-6">Nuevas Amistades</h3>
            <p class="text-2xl text-gray-700 leading-relaxed font-medium">
                Conectamos a personas con intereses comunes para que nadie se sienta solo.
            </p>
        </div>

        <div class="bg-white p-10 rounded-[40px] border-4 border-gray-100 shadow-md hover:border-[#bc6a50] transition-colors text-center">
            <div class="w-24 h-24 bg-[#F8D7DA]/30 rounded-3xl flex items-center justify-center mb-8 mx-auto">
                <i class="bi bi-calendar-event-fill text-5xl text-[#bc6a50]"></i>
            </div>
            <h3 class="text-4xl font-black text-[#32424D] mb-6">Actividades Diarias</h3>
            <p class="text-2xl text-gray-700 leading-relaxed font-medium">
                Talleres, paseos y charlas. Siempre hay algo emocionante ocurriendo.
            </p>
        </div>

        <div class="bg-white p-10 rounded-[40px] border-4 border-gray-100 shadow-md hover:border-[#32424D] transition-colors text-center">
            <div class="w-24 h-24 bg-[#32424D]/10 rounded-3xl flex items-center justify-center mb-8 mx-auto">
                <i class="bi bi-shield-check text-5xl text-[#32424D]"></i>
            </div>
            <h3 class="text-4xl font-black text-[#32424D] mb-6">Seguro y Cercano</h3>
            <p class="text-2xl text-gray-700 leading-relaxed font-medium">
                Un entorno diseñado con cariño y respeto para su total tranquilidad.
            </p>
        </div>
    </section>

    <section class="bg-[#32424D] text-white rounded-[50px] p-12 md:p-20 text-center">
        <div class="max-w-5xl mx-auto">
            <i class="bi bi-quote text-8xl text-[#E8D258] mb-8 block"></i>
            <p class="text-4xl md:text-5xl italic font-bold leading-tight mb-12 text-white">
                "Desde que me uní a Tenderete, mis tardes son mucho más alegres. ¡He conocido a gente maravillosa!"
            </p>
            <div class="flex items-center justify-center gap-6">
                <div class="w-20 h-20 bg-[#E8D258] rounded-full flex items-center justify-center text-[#32424D] font-black text-3xl">
                    M
                </div>
                <div class="text-left">
                    <p class="text-3xl font-black text-[#E8D258]">María G.</p>
                    <p class="text-xl text-gray-300">Usuaria desde 2024</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#F1E498] rounded-[50px] p-12 md:p-20 border-dashed border-8 border-[#32424D] flex flex-col items-center text-center gap-10">
        <div>
            <h2 class="text-5xl md:text-6xl font-black text-[#32424D] mb-6">¿Listo para formar parte?</h2>
            <p class="text-3xl text-[#32424D]/80 font-bold">El registro es gratuito y muy sencillo.</p>
        </div>
        <a href="{{ route('pagina.login_usuarios') }}" 
           class="bg-[#bc6a50] text-white text-4xl font-black px-16 py-8 rounded-full hover:bg-[#a55a43] transition-colors shadow-2xl">
            ¡Registrarme Gratis Ahora!
        </a>
    </section>
</div>
@endsection