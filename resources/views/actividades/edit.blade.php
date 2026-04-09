<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Editar Actividad') }}: {{ $actividad->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    
                    {{-- IMPORTANTE: Ruta cambiada a actividades.update --}}
                    <form method="POST" action="{{ route('actividades.update', $actividad) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nombre --}}
                            <div class="md:col-span-2">
                                <label for="nombre" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Nombre de la Actividad</label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $actividad->nombre) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Descripción --}}
                             <div class="md:col-span-2">
                                <label for="descripcion" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Descripción Detallada</label>
                                <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion', $actividad->descripcion) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('descripcion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Fecha --}}
                            <div>
                                <label for="fecha" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Fecha</label>
                                <input type="date" name="fecha" id="fecha" 
                                    value="{{ old('fecha', $actividad->fecha ? \Carbon\Carbon::parse($actividad->fecha)->format('Y-m-d') : '') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('fecha') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Hora --}}
                            <div>
                                <label for="hora" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Hora</label>
                                <input type="text" name="hora" id="hora" value="{{ old('hora', $actividad->hora) }}" placeholder="Ej: 18:00"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('hora') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Lugar --}}
                            <div>
                                <label for="lugar" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Lugar</label>
                                <input type="text" name="lugar" id="lugar" value="{{ old('lugar', $actividad->lugar) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('lugar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Precio --}}
                            <div>
                                <label for="precio" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Precio (€)</label>
                                <input type="number" step="0.01" name="precio" id="precio" value="{{ old('precio', $actividad->precio) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('precio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Cupos --}}
                            <div>
                                <label for="cupos" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Cupos / Plazas</label>
                                <input type="number" name="cupos" id="cupos" value="{{ old('cupos', $actividad->cupos) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('cupos') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Imagen (Opcional) --}}
                            <div>
                                <label for="imagen" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Cambiar Imagen</label>
                                <input type="file" name="imagen" id="imagen" 
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end items-center space-x-3">
                            
                            {{-- Botón Cancelar --}}
                            <a href="{{ route('actividades.index') }}" 
                                class="inline-flex items-center justify-center w-48 h-10 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 transition duration-150 shadow-sm">
                                Cancelar
                            </a>

                            {{-- Botón Guardar (Verde para que se vea bien) --}}
                            <button type="submit" 
                                style="background-color: #16a34a;" {{-- Estilo forzado por si falla el green-600 --}}
                                class="inline-flex items-center justify-center w-48 h-10 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 transition duration-150 shadow-sm">
                                Guardar Cambios
                            </button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>