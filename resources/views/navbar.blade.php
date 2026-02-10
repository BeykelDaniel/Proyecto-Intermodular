<nav class="bg-[#ebd08e] shadow-md py-2">
    <div class="container mx-auto px-4 flex flex-wrap items-center justify-around">

        <a class="flex items-center" href="{{ route('pagina.inicio') }}">
            <img src="{{ asset('logo.png') }}" alt="Tenderete Logo"
                class="h-[80px] w-[80px] rounded-full object-cover border-2 border-[#32424D] shadow-sm"
                style="clip-path: circle(50% at center);">
        </a>

        <button data-collapse-toggle="navbar-default" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-[#32424D] rounded-lg md:hidden hover:bg-[#d9c183]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>

        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 md:flex-row md:space-x-8 md:mt-0 items-center">

                <li class="relative group">
                    <button class="flex items-center py-2 px-3 text-[#32424D] font-bold hover:text-white transition">
                        Mis Actividades
                        <svg class="w-2.5 h-2.5 ms-2.5" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <div class="absolute z-10 hidden group-hover:block bg-white rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-gray-700">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Actividad 1</a></li>
                        </ul>
                    </div>
                </li>

                <li><a href="#" class="block py-2 px-3 text-[#32424D] font-bold hover:text-white">Comunidades</a></li>

                <li class="md:ml-4">
                    <form action="{{ route('pagina.inicio') }}" method="GET" class="flex items-center">
                        <input type="search" name="q"
                            class="block w-full p-2 text-sm text-[#32424D] border border-gray-300 rounded-lg bg-white focus:ring-[#32424D]"
                            placeholder="Buscar...">
                        <button type="submit"
                            class="p-2 ms-2 text-sm font-medium text-white bg-[#32424D] rounded-lg hover:bg-[#4a5f6d] transition">
                            Buscar
                        </button>
                    </form>
                </li>

                <li><a href="#" class="block py-2 px-3 text-[#32424D] font-bold hover:text-white">Nosotros</a></li>
                <li><a href="#" class="block py-2 px-3 text-[#32424D] font-bold hover:text-white">Mis Amigos</a></li>

                @auth
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block py-2 px-3 text-red-700 font-bold hover:text-red-500 uppercase">
                            Salir
                        </button>
                    </form>
                </li>
                @else
                <li>
                    <a href="{{ route('pagina.login_usuarios') }}"
                        class="block py-2 px-3 text-[#32424D] font-bold hover:text-white">
                        Login
                    </a>
                </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>