@php
    function generarColorLocal($str) {
        $colores = ['#bc6a50', '#2d6a4f', '#1d3557', '#e63946', '#ffb703', '#8338ec', '#0077b6'];
        $hash = 0; 
        for ($i = 0; $i < strlen($str); $i++) {
            $hash = ord($str[$i]) + (($hash << 5) - $hash);
        }
        $index = abs($hash % count($colores));
        return $colores[$index];
    }
@endphp



<!-- Sidebar Principal -->
<nav id="sidebar"
    class="bg-[#D4B830] shadow-xl fixed left-0 top-0 h-full w-full lg:w-64 flex flex-col z-[70] overflow-y-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
    
    <!-- Botón cerrar móvil -->
    <button id="menu-close" aria-label="Cerrar menú" class="lg:hidden absolute top-6 right-6 text-white hover:text-gray-200">
        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Logo Sidebar -->
    <div class="w-full flex justify-center mt-6 lg:mt-12 mb-6 lg:mb-12">
        <a href="{{ route('pagina.inicio') }}" class="block p-1 bg-white rounded-full shadow-lg transform hover:scale-105 transition-transform">
            <img src="{{ asset('logo.png') }}" class="h-20 w-20 lg:h-32 lg:w-32 rounded-full border-[3px] border-[#D4B830] object-cover">
        </a>
    </div>

    <!-- Enlaces (Todos con tamaño text-2xl / lg:text-xl uniforme) -->
    <ul id="nav-lista-nueva" class="w-full flex flex-col items-start px-8 gap-y-8 font-black text-[#32424D] text-lg lg:text-lg">
        
        <li class="w-full hidden lg:block">
            <a href="{{ route('pagina.amigos') }}" class="hover:text-[#C2841D] transition-colors flex items-center gap-4 w-full uppercase text-2xl lg:text-xl">
               <i class="bi bi-people-fill text-2xl lg:text-xl"></i> Mis Amigos
            </a>
        </li>
        
        <!-- MIS ACTIVIDADES - Componente Vue -->
        <li class="w-full hidden lg:block">
            <calendario-navbar 
                :initial-inscripciones="{{ json_encode(array_values($inscripciones_data ?? [])) }}" 
                route-inscritas="{{ route('actividades.inscritas') }}"
                :is-auth="{{ Auth::check() ? 'true' : 'false' }}">
            </calendario-navbar>
        </li>

        <li class="w-full hidden lg:block">
            <a href="{{ route('pagina.comunidades') }}" class="hover:text-[#C2841D] transition-colors flex items-center gap-4 w-full uppercase text-2xl lg:text-xl transform hover:translate-x-2 transition-transform">
                <i class="fa-solid fa-users text-2xl lg:text-xl"></i> Comunidades
            </a>
        </li>

        @auth
        <li class="w-full">
            <!-- NOTIFICACIONES (Amigos) - Componente Vue -->
            <notificaciones-amistad 
                route-index="{{ route('notificaciones.index') }}"
                route-aceptar="{{ route('amigos.accept', ':id') }}"
                route-rechazar="{{ route('amigos.reject', ':id') }}"
                csrf="{{ csrf_token() }}">
            </notificaciones-amistad>
        </li>

        <li class="w-full mt-auto pt-6 border-t border-[#32424D]/20">
            <a href="{{ route('profile.edit') }}" class="hover:text-[#C2841D] transition-colors flex items-center gap-4 w-full uppercase text-2xl lg:text-xl">
                @if(Auth::check() && Auth::user()->perfil_foto)
                    <img src="{{ asset(Auth::user()->perfil_foto) }}" class="w-10 h-10 rounded-full border-2 border-[#32424D] object-cover" alt="">
                @else
                    <i class="bi bi-gear-fill text-2xl lg:text-xl" aria-hidden="true"></i>
                @endif
                Ajustes
            </a>
        </li>

        <li class="w-full mb-8 lg:mb-8 pt-4">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="hover:scale-105 transition-transform flex items-center gap-4 w-full text-[#bc6a50] uppercase text-left text-2xl lg:text-xl">
                    <i class="fa-solid fa-right-from-bracket text-2xl lg:text-xl" aria-hidden="true"></i>
                    Salir
                </button>
            </form>
        </li>
        @else
        <li class="w-full mt-auto pt-8 border-t border-[#32424D]/20 mb-8 lg:mb-8">
            <a href="{{ route('pagina.login_usuarios') }}" class="hover:text-[#C2841D] transition-colors flex items-center gap-4 w-full uppercase text-2xl lg:text-xl">
                <i class="fa-solid fa-user text-2xl lg:text-xl"></i> Entrar
            </a>
        </li>
        @endauth
    </ul>
</nav>



<!-- Barra de Navegación Inferior (Móvil) -->
<div id="barra-inferior" class="lg:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 z-[9999] flex justify-around items-center py-2 shadow-[0_-10px_40px_rgba(0,0,0,0.15)] rounded-t-[30px]">
    <a href="{{ route('pagina.inicio') }}" class="flex-1 flex flex-col items-center gap-1 transition-all active:scale-90 {{ request()->routeIs('pagina.inicio') ? 'text-[#bc6a50]' : 'text-[#32424D]/60' }}" style="color: {{ request()->routeIs('pagina.inicio') ? '#bc6a50' : '#32424Dbb' }} !important;">
        <i class="bi bi-house-door-fill text-[1.4rem]"></i>
        <span class="text-[10px] font-black uppercase leading-none">Inicio</span>
    </a>
    <a href="{{ route('pagina.amigos') }}" class="flex-1 flex flex-col items-center gap-1 transition-all active:scale-90 {{ request()->routeIs('pagina.amigos') ? 'text-[#bc6a50]' : 'text-[#32424D]/60' }}" style="color: {{ request()->routeIs('pagina.amigos') ? '#bc6a50' : '#32424Dbb' }} !important;">
        <i class="bi bi-people-fill text-[1.4rem]"></i>
        <span class="text-[10px] font-black uppercase leading-none">Amigos</span>
    </a>
    <a href="{{ route('actividades.mis_inscripciones') }}" class="flex-1 flex flex-col items-center gap-1 transition-all active:scale-90 {{ request()->routeIs('actividades.mis_inscripciones') ? 'text-[#bc6a50]' : 'text-[#32424D]/60' }}" style="color: {{ request()->routeIs('actividades.mis_inscripciones') ? '#bc6a50' : '#32424Dbb' }} !important;">
        <i class="bi bi-calendar-check-fill text-[1.4rem]"></i>
        <span class="text-[10px] font-black uppercase leading-none">Citas</span>
    </a>
    <a href="{{ route('pagina.comunidades') }}" class="flex-1 flex flex-col items-center justify-center gap-1 transition-all active:scale-90 {{ request()->routeIs('pagina.comunidades') ? 'text-[#bc6a50]' : 'text-[#32424D]/60' }}" style="color: {{ request()->routeIs('pagina.comunidades') ? '#bc6a50' : '#32424Dbb' }} !important;">
        <i class="fa-solid fa-users text-[1.4rem]"></i>
        <span class="text-[10px] font-black uppercase leading-none">Comunidad</span>
    </a>
    <button id="menu-toggle" class="flex-1 flex flex-col items-center justify-center gap-1 transition-all active:scale-90 text-[#32424D]/60 focus:outline-none" style="color: #32424Dbb !important;">
        <i class="bi bi-list text-[1.8rem] leading-none mb-[-2px]"></i>
        <span class="text-[10px] font-black uppercase leading-none">Menú</span>
    </button>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const closeBtn = document.getElementById('menu-close');
        
        if (menuToggle && sidebar && closeBtn) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                document.body.style.overflow = 'hidden';
            });

            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                document.body.style.overflow = '';
            });

            // Opcional: Cerrar al hacer click en enlaces en móvil
            // sidebar.querySelectorAll('a').forEach(link => {
            //     link.addEventListener('click', (e) => {
            //         if(window.innerWidth < 1024) { 
            //             setTimeout(() => {
            //                sidebar.classList.add('-translate-x-full');
            //                document.body.style.overflow = '';
            //             }, 100);
            //         }
            //     });
            // });
        }
    });
</script>
@endpush