@extends('layouts.landing')

@section('title', 'Bienvenido a Tenderete')

@section('contenido')
<div class="space-y-16 pb-12">

<section x-data="{ 
    activeSlide: 0, 
    slides: [
        { 
            image: '{{ asset('banner.png') }}', 
            title: 'Tu comunidad, <br><span class=\'text-[#bc6a50]\'>más viva que nunca.</span>', 
            desc: 'Únete a Tenderete: el lugar donde compartir momentos, hacer nuevos amigos y disfrutar de actividades pensadas para ti.' 
        },
        { 
            image: '{{ asset('storage/album/Lz9ejmT3uceJh72GmBoR9qMSZJZVHUPoes8STsJ8.jpg') }}', 
            title: 'Actividades <br><span class=\'text-[#bc6a50]\'>para todos.</span>', 
            desc: 'Talleres, paseos y charlas pensadas específicamente para tu bienestar y diversión.' 
        },
        { 
            image: '{{ asset('logo.png') }}', 
            title: 'Un entorno <br><span class=\'text-[#bc6a50]\'>cerca de ti.</span>', 
            desc: 'Diseñado con cariño y respeto, pensando siempre en tu comodidad y seguridad.' 
        }
    ],
    next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
    prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
    init() {
        setInterval(() => this.next(), 8000); 
    }
}" class="relative bg-[#E8D258] rounded-[40px] overflow-hidden border-4 border-[#32424D] shadow-2xl h-[600px] md:h-[700px]">
    
    <template x-for="(slide, index) in slides" :key="index">
        <div x-show="activeSlide === index" 
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             class="absolute inset-0">
            
            <img :src="slide.image" class="w-full h-full object-cover opacity-30" alt="Fondo Tenderete">
            
            <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 md:p-16 z-10">
                <h1 class="text-5xl md:text-7xl font-black text-[#32424D] leading-tight mb-6" x-html="slide.title"></h1>
                
                <p class="text-2xl md:text-3xl text-[#32424D]/90 font-medium mb-10 max-w-4xl leading-relaxed" x-text="slide.desc"></p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('pagina.login_usuarios') }}" 
                       class="bg-[#32424D] text-[#E8D258] text-2xl font-bold px-10 py-5 rounded-full hover:scale-105 transition-transform shadow-lg">
                        Empezar ahora
                    </a>
                    <a href="#servicios" 
                       class="bg-white text-[#32424D] border-3 border-[#32424D] text-2xl font-bold px-10 py-5 rounded-full hover:bg-gray-50 transition-colors shadow-md">
                        Saber más
                    </a>
                </div>
            </div>
        </div>
    </template>

    <div class="absolute right-[-5%] bottom-[-10%] opacity-10 pointer-events-none hidden lg:block z-0">
        <svg width="400" height="400" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="100" cy="100" r="80" stroke="#32424D" stroke-width="20"/>
            <path d="M100 20V180M20 100H180" stroke="#32424D" stroke-width="20" stroke-linecap="round"/>
        </svg>
    </div>

    <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 p-4 rounded-full text-[#32424D] hover:bg-white transition-colors shadow-md z-20">
        <i class="bi bi-chevron-left text-3xl"></i>
    </button>
    <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 p-4 rounded-full text-[#32424D] hover:bg-white transition-colors shadow-md z-20">
        <i class="bi bi-chevron-right text-3xl"></i>
    </button>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3 z-20">
        <template x-for="(_, index) in slides" :key="index">
            <button @click="activeSlide = index" 
                    :class="activeSlide === index ? 'bg-[#32424D] w-8' : 'bg-[#32424D]/30 w-3'"
                    class="h-3 rounded-full transition-all duration-300"></button>
        </template>
    </div>
</section>


    <!-- Services Section -->
    <section id="servicios" class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[30px] border-2 border-gray-100 shadow-sm hover:border-[#E8D258] transition-colors">
            <div class="w-16 h-16 bg-[#F1E498] rounded-2xl flex items-center justify-center mb-6">
                <i class="bi bi-people-fill text-3xl text-[#32424D]"></i>
            </div>
            <h3 class="text-3xl font-bold text-[#32424D] mb-4">Nuevas Amistades</h3>
            <p class="text-xl text-gray-600 leading-relaxed">
                Conectamos a personas con intereses comunes para que nadie se sienta solo.
            </p>
        </div>

        <div class="bg-white p-8 rounded-[30px] border-2 border-gray-100 shadow-sm hover:border-[#bc6a50] transition-colors">
            <div class="w-16 h-16 bg-[#F8D7DA]/30 rounded-2xl flex items-center justify-center mb-6">
                <i class="bi bi-calendar-event-fill text-3xl text-[#bc6a50]"></i>
            </div>
            <h3 class="text-3xl font-bold text-[#32424D] mb-4">Actividades Diarias</h3>
            <p class="text-xl text-gray-600 leading-relaxed">
                Talleres, paseos y charlas. Siempre hay algo emocionante ocurriendo en Tenderete.
            </p>
        </div>

        <div class="bg-white p-8 rounded-[30px] border-2 border-gray-100 shadow-sm hover:border-[#32424D] transition-colors">
            <div class="w-16 h-16 bg-[#32424D]/10 rounded-2xl flex items-center justify-center mb-6">
                <i class="bi bi-shield-check text-3xl text-[#32424D]"></i>
            </div>
            <h3 class="text-3xl font-bold text-[#32424D] mb-4">Seguro y Cercano</h3>
            <p class="text-xl text-gray-600 leading-relaxed">
                Un entorno diseñado con cariño y respeto, pensando en la comodidad del usuario.
            </p>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="bg-[#32424D] text-white rounded-[40px] p-8 md:p-16 text-center">
        <div class="max-w-4xl mx-auto">
            <i class="bi bi-quote text-6xl text-[#E8D258] mb-6 block"></i>
            <p class="text-3xl md:text-4xl italic font-medium leading-normal mb-8 text-gray-100">
                "Desde que me uní a Tenderete, mis tardes son mucho más alegres. ¡He conocido a gente maravillosa!"
            </p>
            <div class="flex items-center justify-center gap-4">
                <div class="w-14 h-14 bg-[#E8D258] rounded-full flex items-center justify-center text-[#32424D] font-bold text-xl">
                    M
                </div>
                <div class="text-left">
                    <p class="text-xl font-bold">María G.</p>
                    <p class="text-gray-400">Usuaria desde 2024</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-[#F1E498] rounded-[40px] p-8 md:p-16 border-dashed border-4 border-[#32424D] flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="text-center md:text-left">
            <h2 class="text-4xl font-black text-[#32424D] mb-4">¿Listo para formar parte?</h2>
            <p class="text-2xl text-[#32424D]/70">El registro es gratuito y solo te llevará un minuto.</p>
        </div>
        <a href="{{ route('pagina.login_usuarios') }}" 
           class="bg-[#bc6a50] text-white text-2xl font-bold px-12 py-6 rounded-full hover:bg-[#a55a43] transition-colors shadow-xl">
            Registrarme Gratis
        </a>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Portada cargada con éxito');
        
        // Animación suave al hacer scroll a servicios
        document.querySelector('a[href="#servicios"]').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endpush