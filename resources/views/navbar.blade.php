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
    class="bg-[#E8D258] shadow-md h-24 md:h-28 flex items-center relative border-b-2 border-[#32424D]/10 px-6 md:px-12">
    <div class="w-full flex items-center justify-between">

        <div class="shrink-0">
            <a href="{{ route('pagina.inicio') }}" class="block">
                <img src="{{ asset('logo.png') }}"
                    class="h-[70px] w-[70px] md:h-[95px] md:w-[95px] rounded-full border-4 border-[#32424D] object-cover shadow-md">
            </a>
        </div>

        <button id="menu-toggle" class="lg:hidden text-[#32424D] focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <ul id="nav-menu" class="flex flex-row items-center gap-x-6 md:gap-x-10 lg:gap-x-14 font-bold">
            <li><a href="{{ route('pagina.amigos') }}"
                    class="text-[#32424D] uppercase whitespace-nowrap text-xs md:text-base hover:text-[#C2841D] transition-colors"><i
                        class="bi bi-people-fill"></i> <br> Mis Amigos</a>
            </li>
            <!-- MIS ACTIVIDADES - Componente Vue -->
            <calendario-navbar 
                initial-inscripciones="{{ json_encode(array_values($inscripciones_data ?? [])) }}" 
                route-inscritas="{{ route('actividades.inscritas') }}"
                :is-auth="{{ Auth::check() ? 'true' : 'false' }}">
            </calendario-navbar>

            <li><a href="{{ route('pagina.comunidades') }}"
                    class="text-[#32424D] uppercase whitespace-nowrap text-xs md:text-base hover:text-[#C2841D] transition-colors">Comunidades</a>
            </li>
            <li><a href="{{ route('pagina.nosotros') }}"
                    class="text-[#32424D] uppercase whitespace-nowrap text-xs md:text-base hover:text-[#C2841D] transition-colors">Nosotros</a>
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
            <li>
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center p-2 text-[#32424D] hover:text-[#C2841D] transition-colors">
                    <i class="bi bi-gear-fill text-2xl"></i>
                    <span class="text-[10px] font-black uppercase mt-1">Ajustes</span>
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="flex flex-col items-center text-[#bc6a50] font-black uppercase whitespace-nowrap text-xs md:text-base hover:scale-105 transition-transform">
                        <i class="fa-solid fa-right-from-bracket text-2xl"></i>
                        <span class="text-[10px] font-black mt-1">Salir</span>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuToggle = document.getElementById('menu-toggle');
        const navMenu = document.getElementById('nav-menu');
        if (menuToggle && navMenu) {
            menuToggle.addEventListener('click', () => {
                navMenu.classList.toggle('show');
            });
        }
    });
</script>
@endpush