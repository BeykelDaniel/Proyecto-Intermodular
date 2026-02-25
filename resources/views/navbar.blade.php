<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-calendar {
        background: #fdf6e9 !important;
        border: 2px solid #32424D !important;
        width: 320px !important;
    }

    .flatpickr-day {
        font-size: 1.1rem !important;
        font-weight: bold !important;
        height: 45px !important;
        line-height: 45px !important;
    }

    .dia-resaltado {
        position: relative;
        font-weight: 900 !important;
        color: #32424D !important;
    }

    .dia-resaltado::after {
        content: "";
        position: absolute;
        bottom: 8px;
        left: 10%;
        right: 10%;
        height: 8px;
        opacity: 0.5;
        border-radius: 4px;
        background-color: var(--color-actividad, #bc6a50);
        z-index: -1;
    }

    [x-cloak] {
        display: none !important;
    }

    /* Estilos específicos para la separación y el móvil */
    @media (max-width: 1024px) {
        #nav-menu {
            display: none;
            /* Se oculta por defecto en móvil */
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: #F1E498;
            flex-direction: column;
            padding: 20px;
            gap: 15px;
            border-bottom: 2px solid #32424D;
            z-index: 100;
        }

        #nav-menu.show {
            display: flex;
        }

        .dropdown-container {
            position: static !important;
        }

        .dropdown-content {
            width: 90% !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
        }
    }
</style>

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
            <li class="relative dropdown-container" x-data="{ dropdown: false }">
                <button @click="dropdown = !dropdown; if(dropdown) setTimeout(() => window.fpInstancia.redraw(), 50)"
                    class="text-[#32424D] uppercase flex items-center whitespace-nowrap text-xs md:text-base hover:text-[#C2841D] transition-colors">
                    Mis Actividades
                    <svg class="w-4 h-4 ms-2" :class="{'rotate-180': dropdown}" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="dropdown" @click.away="dropdown = false" x-transition x-cloak
                    class="dropdown-content absolute z-50 mt-6 bg-white rounded-[30px] shadow-2xl p-6 border border-gray-100 left-1/2 -translate-x-1/2 min-w-[320px] md:min-w-[350px]">
                    <div id="calendario-inline"></div>
                    <div class="mt-4 border-t-2 pt-4">
                        <p class="text-[11px] font-black text-gray-400 uppercase text-center mb-3">Tus próximas citas
                        </p>
                        <ul id="lista-navbar-inscripciones" class="space-y-3 max-h-[200px] overflow-y-auto">
                            <li id="no-hay-actividades" class="text-sm text-gray-400 italic text-center">Aún no tienes
                                planes</li>
                        </ul>
                    </div>
                </div>
            </li>

            <li><a href="{{ route('pagina.comunidades') }}"
                    class="text-[#32424D] uppercase whitespace-nowrap text-xs md:text-base hover:text-[#C2841D] transition-colors">Comunidades</a>
            </li>
            <li><a href="{{ route('pagina.nosotros') }}"
                    class="text-[#32424D] uppercase whitespace-nowrap text-xs md:text-base hover:text-[#C2841D] transition-colors">Nosotros</a>
            </li>


            @auth
            <li>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="text-[#bc6a50] font-black uppercase whitespace-nowrap text-xs md:text-base hover:scale-105 transition-transform"><i
                            class="fa-solid fa-user"></i> Salir</button>
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lógica para abrir/cerrar menú en móvil
        const menuToggle = document.getElementById('menu-toggle');
        const navMenu = document.getElementById('nav-menu');
        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('show');
        });

        // Tu lógica de Flatpickr y Actividades
        function generarColor(str) {
            const colores = ['#bc6a50', '#2d6a4f', '#1d3557', '#e63946', '#ffb703', '#8338ec', '#0077b6'];
            let hash = 0; for (let i = 0; i < str.length; i++) hash = str.charCodeAt(i) + ((hash << 5) - hash);
            return colores[Math.abs(hash) % colores.length];
        }

        window.inscripcionesRealizadas = [
            @auth @foreach(auth() -> user() -> actividades as $act)
            { fecha: "{{ $act->fecha }}", nombre: "{{ $act->nombre }}", color: generarColor("{{ $act->nombre }}"), fechaFormateada: "{{ \Carbon\Carbon::parse($act->fecha)->format('d/m/Y') }}" },
            @endforeach @endauth
        ];

        window.fpInstancia = flatpickr("#calendario-inline", {
            inline: true, locale: "es",
            onDayCreate: function (dObj, dStr, fp, dayElem) {
                const f = dayElem.dateObj.toLocaleDateString('en-CA');
                const act = window.inscripcionesRealizadas.find(a => a.fecha === f);
                if (act) {
                    dayElem.classList.add("dia-resaltado");
                    dayElem.style.setProperty('--color-actividad', act.color);
                }
            }
        });

        function addUI(act) {
            const lista = document.getElementById('lista-navbar-inscripciones');
            if (document.getElementById('no-hay-actividades')) document.getElementById('no-hay-actividades').remove();
            const li = document.createElement('li');
            li.className = "flex items-center gap-3 p-2 rounded-xl bg-gray-50 border-l-4 shadow-sm";
            li.style.borderLeftColor = act.color;
            li.innerHTML = `<div class="flex-1"><p class="text-[#32424D] font-bold text-sm leading-tight">${act.nombre}</p><p class="text-[10px] text-gray-500 italic">${act.fechaFormateada}</p></div>`;
            lista.prepend(li);
        }

        window.inscripcionesRealizadas.forEach(addUI);
    });
</script>