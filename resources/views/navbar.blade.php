@php
    function generarColorLocal($str) {
        $colores = ['#bc6a50', '#2d6a4f', '#1d3557', '#e63946', '#ffb703', '#8338ec', '#0077b6'];
        $hash = 0; 
        
        for ($i = 0; $i < strlen($str); $i++) {
            // Use bitwise AND with 0xFFFFFFFF to maintain 32-bit consistency
            $hash = ord($str[$i]) + (($hash << 5) - $hash);
        }
        
        // Ensure the index is positive and within bounds
        $index = abs($hash % count($colores));
        
        return $colores[$index];
    }
@endphp
<nav
    class="bg-[#E8D258] shadow-md h-24 md:h-28 flex items-center relative border-b-2 border-[#32424D]/10 px-6 md:px-12 z-[50]">
    <div class="w-full flex items-center justify-between">

        <div class="shrink-0">
            <a href="{{ route('pagina.inicio') }}" class="block">
                <img src="{{ asset('logo.png') }}"
                    class="h-[70px] w-[70px] md:h-[95px] md:w-[95px] rounded-full border-4 border-[#32424D] object-cover shadow-md">
            </a>
        </div>

        <button id="menu-toggle" 
            aria-label="Abrir menú de navegación"
            aria-expanded="false"
            aria-controls="nav-menu"
            class="lg:hidden text-[#32424D] focus:outline-none p-3 border-2 border-[#32424D] rounded-xl hover:bg-[#32424D]/5 transition-colors">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
<!-- slide -->
        <ul id="nav-menu" class="hidden lg:flex flex-row items-center gap-x-6 md:gap-x-10 lg:gap-x-14 font-bold">
            <!-- Botón cerrar móvil -->
            <button id="menu-close" aria-label="Cerrar menú de navegación" class="lg:hidden p-2">
                <svg class="w-12 h-12 text-[#32424D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <li class="flex items-start gap-3"><a href="{{ route('pagina.amigos') }}"
                    class="text-[#32424D] uppercase whitespace-nowrap text-xs md:text-base hover:text-[#C2841D] transition-colors"><i
                        class="bi bi-people-fill"></i> Mis Amigos</a>
            </li>
            <!-- MIS ACTIVIDADES - Componente Vue -->
            <calendario-navbar 
                :initial-inscripciones="{{ json_encode(array_values($inscripciones_data ?? [])) }}" 
                route-inscritas="{{ route('actividades.inscritas') }}"
                :is-auth="{{ Auth::check() ? 'true' : 'false' }}">
            </calendario-navbar>

            <li class="flex items-start gap-3"><a href="{{ route('pagina.comunidades') }}"
                    class="text-[#32424D] uppercase whitespace-nowrap text-xs md:text-base hover:text-[#C2841D] transition-colors">Comunidades</a>
            </li>


            @auth
            <!-- NOTIFICACIONES (Amigos) - Componente Vue -->
            <notificaciones-amistad 
                route-index="{{ route('notificaciones.index') }}"
                route-aceptar="{{ route('amigos.accept', ':id') }}"
                route-rechazar="{{ route('amigos.reject', ':id') }}"
                csrf="{{ csrf_token() }}">
            </notificaciones-amistad>

            <!-- PERFIL (Configuración) -->
            <li class="flex items-center gap-2">
                <a href="{{ route('profile.edit') }}" 
                    aria-label="Ir a ajustes de perfil"
                    class="flex flex-col items-center p-2 text-[#32424D] hover:text-[#C2841D] transition-colors">
                    @if(Auth::user()->perfil_foto)
                        <img src="{{ asset(Auth::user()->perfil_foto) }}" class="w-10 h-10 rounded-full border-2 border-[#32424D] object-cover" alt="">
                    @else
                        <i class="bi bi-gear-fill text-3xl" aria-hidden="true"></i>
                    @endif
                    <span class="text-xs font-black uppercase mt-1">Ajustes</span>
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        aria-label="Cerrar sesión"
                        class="flex flex-col items-center text-[#bc6a50] font-black uppercase whitespace-nowrap text-xs md:text-base hover:scale-105 transition-transform">
                        <i class="fa-solid fa-right-from-bracket text-3xl" aria-hidden="true"></i>
                        <span class="text-xs font-black mt-1">Salir</span>
                    </button>
                </form>
            </li>
            @else
            <li><a href="{{ route('pagina.login_usuarios') }}"
                    class="text-[#32424D] uppercase whitespace-nowrap text-xs md:text-base hover:text-[#C2841D] transition-colors"><i
                        class="fa-solid fa-user"></i> Entrar</a></li>
            @endauth
        </ul>
    </div>
</nav>

<style>
    @media (max-width: 1023px) {
        #nav-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-color: #E8D258;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            z-index: 1000;
            padding: 2rem;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            display: flex;
        }
        #nav-menu.show {
            transform: translateX(0);
        }
        #nav-menu li {
            width: 100%;
            text-align: center;
        }
        #nav-menu a, #nav-menu button {
            font-size: 1.5rem !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }
        #menu-close {
            position: absolute;
            top: 2rem;
            right: 2rem;
            display: block !important;
            z-index: 1001;
        }
    }
    #menu-close { display: none !important; }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuToggle = document.getElementById('menu-toggle');
        const navMenu = document.getElementById('nav-menu');
        const closeBtn = document.getElementById('menu-close');
        
        if (menuToggle && navMenu && closeBtn) {
            menuToggle.addEventListener('click', () => {
                navMenu.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            closeBtn.addEventListener('click', () => {
                navMenu.classList.remove('show');
                document.body.style.overflow = '';
            });

            // Close when clicking on any link
            navMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    navMenu.classList.remove('show');
                    document.body.style.overflow = '';
                });
            });
        }
    });
</script>
@endpush