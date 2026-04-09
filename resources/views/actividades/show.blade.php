<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Detalles de la Actividad') }}: {{ $actividad->nombre }}
            </h2>
            <a href="{{ route('actividades.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition shadow-sm">
                &larr; Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    {{-- Encabezado de la Actividad --}}
                    <div class="flex items-center border-b border-gray-100 pb-6 mb-6">
                        <div class="h-20 w-20 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 shadow-sm">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $actividad->nombre }}</h3>
                            <p class="text-sm text-gray-500 italic">Creada el {{ $actividad->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    {{-- Información Detallada --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Descripción (Ocupa las dos columnas en MD) --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 md:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Descripción</label>
                            <p class="mt-1 text-gray-800">{{ $actividad->descripcion }}</p>
                        </div>

                        {{-- Fecha --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Fecha del Evento</label>
                            <p class="mt-1 text-lg text-gray-800 font-medium">
                                {{ $actividad->fecha ? \Carbon\Carbon::parse($actividad->fecha)->format('d \d\e F, Y') : 'N/A' }}
                            </p>
                        </div>

                        {{-- Hora --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Hora</label>
                            <p class="mt-1 text-lg text-gray-800 font-medium">{{ $actividad->hora }}</p>
                        </div>

                        {{-- Lugar --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Lugar</label>
                            <p class="mt-1 text-lg text-gray-800 font-medium">{{ $actividad->lugar }}</p>
                        </div>

                        {{-- Precio --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Precio</label>
                            <p class="mt-1 text-lg text-green-700 font-bold">
                                {{ is_numeric($actividad->precio) ? number_format($actividad->precio, 2) . '€' : $actividad->precio }}
                            </p>
                        </div>

                        {{-- Cupos --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Cupos Disponibles</label>
                            <p class="mt-1 text-lg text-gray-800 font-medium">{{ $actividad->cupos }} plazas</p>
                        </div>
                    </div>

                    {{-- Acciones del Pie --}}
                    <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end items-center space-x-3">
                        
                        {{-- Botón Editar (Verde con estilo forzado) --}}
                        <a href="{{ route('actividades.edit', $actividad) }}" 
                            style="background-color: #16a34a;"
                            class="inline-flex items-center justify-center w-48 h-10 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 transition shadow-sm">
                            Editar Actividad
                        </a>
                        
                        {{-- Botón Eliminar --}}
                        <form action="{{ route('actividades.destroy', $actividad) }}" method="POST" 
                              onsubmit="return confirm('¿Estás seguro de eliminar esta actividad?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="inline-flex items-center justify-center w-48 h-10 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition shadow-sm">
                                Eliminar Actividad
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>