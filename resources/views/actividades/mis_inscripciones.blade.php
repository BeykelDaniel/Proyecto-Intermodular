<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-calendar-check-fill text-[#bc6a50]"></i> {{ __('Mis Citas') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <!-- Calendario -->
            <div class="w-full md:w-1/2">
                <div class="bg-white rounded-[30px] p-6 shadow-xl border-t-4 border-[#bc6a50]">
                    <h3 class="text-center font-black text-gray-700 uppercase tracking-wide mb-4">Mi Calendario</h3>
                    <div class="bg-indigo-50/50 rounded-[20px] p-2">
                        <div id="calendario-inline" class="w-full"></div>
                    </div>
                </div>
            </div>

            <!-- Lista de Actividades -->
            <div class="w-full md:w-1/2">
                <div class="bg-white rounded-[30px] p-6 shadow-xl border-t-4 border-[#bc6a50] h-full">
                    <h3 class="text-center font-black text-gray-700 uppercase tracking-wide mb-4">Tus Próximas Citas</h3>
                    
                    @if(count($actividades) > 0)
                        <ul class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($actividades as $act)
                                <li class="flex items-start gap-4 p-4 rounded-2xl bg-gray-50 border-l-[6px] shadow-sm transform hover:translate-x-1 transition-transform" style="border-left-color: {{ $act['color'] }}">
                                    <div class="flex-1">
                                        <h4 class="text-[#32424D] font-black text-lg uppercase leading-tight mb-1">{{ $act['nombre'] }}</h4>
                                        <p class="text-gray-500 font-bold text-sm italic mb-2">
                                            <i class="bi bi-clock"></i> {{ $act['fechaFormateada'] }} 
                                            @if($act['hora']) | {{ $act['hora'] }} @endif
                                        </p>
                                        @if($act['lugar'])
                                            <p class="text-gray-600 text-sm">
                                                <i class="bi bi-geo-alt-fill text-[#bc6a50]"></i> {{ ucfirst($act['lugar']) }}
                                            </p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex flex-col items-center justify-center p-8 text-center text-gray-400">
                            <i class="bi bi-journal-x text-5xl mb-4"></i>
                            <p class="font-bold italic">Aún no tienes planes programados.</p>
                            <a href="{{ route('pagina.inicio') }}" class="mt-4 px-6 py-2 bg-[#bc6a50] text-white rounded-full font-bold uppercase text-xs hover:bg-[#a05a44] transition-colors">
                                Buscar Actividades
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const actividades = @json($actividades->values()->all());
            
            flatpickr("#calendario-inline", {
                inline: true,
                locale: "es",
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    const localDate = dayElem.dateObj;
                    const year = localDate.getFullYear();
                    const month = String(localDate.getMonth() + 1).padStart(2, '0');
                    const day = String(localDate.getDate()).padStart(2, '0');
                    const formatStr = `${year}-${month}-${day}`;

                    const act = actividades.find(a => a.fecha && a.fecha.startsWith(formatStr));
                    
                    if (act) {
                        dayElem.style.backgroundColor = act.color + '33'; // 20% opacidad del color
                        dayElem.style.color = act.color;
                        dayElem.style.fontWeight = 'bold';
                        dayElem.style.border = '2px solid ' + act.color;
                        dayElem.title = act.nombre;
                        dayElem.classList.add('cursor-pointer');
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
