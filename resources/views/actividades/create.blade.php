<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ session('success') ? '¡Actividad Registrada!' : ($oper == 'create' ? 'Crear Nueva Actividad' : ($oper
                == 'edit' ? 'Editar Actividad' : 'Detalles')) }}
            </h2>
            <a href="{{ route('actividades.index') }}"
                class="px-4 py-2 bg-white border rounded-lg font-semibold text-xs text-gray-700 uppercase shadow-sm hover:bg-gray-50">
                Volver al Panel
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">

                <div class="p-8">

                    {{-- LÓGICA DE ÉXITO Y BLOQUEO --}}
                    @if (session('success'))
                    <div class="text-center py-10">
                        <div
                            class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ session('success') }}</h3>
                        <p class="text-gray-500 mb-8 font-medium">Los datos han sido guardados y el formulario se
                            encuentra ahora bloqueado.</p>

                        <a href="{{ route('pagina.inicio') }}"
                            class="inline-block bg-[#32424D] hover:bg-black text-white font-black py-4 px-12 rounded-2xl shadow-xl transition-all uppercase tracking-widest text-sm">
                            <i class="bi bi-house-door-fill mr-2"></i> Volver a la página de inicio
                        </a>
                    </div>
                    @else

                    {{-- Alerta de Errores --}}
                    @if ($errors->any())
                    <div class="flex p-4 mb-8 text-sm text-red-800 border-l-4 border-red-500 bg-red-50 rounded-r-xl">
                        <ul class="ml-4 list-disc">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form
                        action="{{ $oper == 'create' ? route('actividades.store') : route('actividades.update', $actividad->id) }}"
                        method="POST">
                        @csrf
                        @if($oper == 'edit') @method('PUT') @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                            @php
                            $inputClasses = "mt-2 block w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl
                            focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all
                            duration-200 font-semibold";
                            $labelClasses = "block text-sm font-bold text-gray-700 tracking-wide ml-1";
                            @endphp

                            {{-- 1. NOMBRE --}}
                            <div class="col-span-2">
                                <label class="{{ $labelClasses }}">Nombre de la Actividad</label>
                                <input type="text" name="nombre" value="{{ old('nombre', $actividad->nombre ?? '') }}"
                                    class="{{ $inputClasses }}" {{ $oper=='show' ? 'disabled' : 'required' }}
                                    placeholder="Ej. Taller de Cerámica">
                            </div>

                            {{-- 2. DESCRIPCIÓN --}}
                            <div class="col-span-2">
                                <label class="{{ $labelClasses }}">Descripción</label>
                                <textarea name="descripcion" rows="3" class="{{ $inputClasses }}" {{ $oper=='show'
                                    ? 'disabled' : 'required' }}
                                    placeholder="Detalla de qué trata la actividad...">{{ old('descripcion', $actividad->descripcion ?? '') }}</textarea>
                            </div>

                            {{-- 3. FECHA --}}
                            <div>
                                <label class="{{ $labelClasses }}">Fecha del Evento</label>
                                <input type="date" name="fecha"
                                    value="{{ old('fecha', isset($actividad->fecha) ? \Carbon\Carbon::parse($actividad->fecha)->format('Y-m-d') : '') }}"
                                    class="{{ $inputClasses }}" {{ $oper=='show' ? 'disabled' : 'required' }}>
                            </div>

                            {{-- 4. HORA --}}
                            <div>
                                <label class="{{ $labelClasses }}">Hora de Inicio</label>
                                <input type="time" name="hora" value="{{ old('hora', $actividad->hora ?? '') }}"
                                    class="{{ $inputClasses }}" {{ $oper=='show' ? 'disabled' : 'required' }}>
                            </div>

                            {{-- 5. LUGAR --}}
                            <div>
                                <label class="{{ $labelClasses }}">Lugar / Ubicación</label>
                                <input type="text" name="lugar" value="{{ old('lugar', $actividad->lugar ?? '') }}"
                                    class="{{ $inputClasses }}" {{ $oper=='show' ? 'disabled' : 'required' }}
                                    placeholder="Ej. Centro Cultural">
                            </div>

                            {{-- 6. PRECIO --}}
                            <div>
                                <label class="{{ $labelClasses }}">Precio (€)</label>
                                <input type="number" step="0.01" name="precio"
                                    value="{{ old('precio', $actividad->precio ?? '') }}" class="{{ $inputClasses }}" {{
                                    $oper=='show' ? 'disabled' : 'required' }} placeholder="0.00">
                            </div>

                            {{-- 7. CUPOS --}}
                            <div>
                                <label class="{{ $labelClasses }}">Cupos (Plazas)</label>
                                <input type="number" name="cupos" value="{{ old('cupos', $actividad->cupos ?? '') }}"
                                    class="{{ $inputClasses }}" {{ $oper=='show' ? 'disabled' : 'required' }}
                                    placeholder="Ej. 20">
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="mt-12 pt-8 border-t border-gray-100 flex justify-end gap-4">
                            @if($oper != 'show')
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-10 rounded-xl shadow-lg transition-all">
                                {{ $oper == 'create' ? 'Crear Actividad' : 'Actualizar Actividad' }}
                            </button>

                            <a href="{{ route('pagina.inicio') }}"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-10 rounded-xl transition-all">
                                Cancelar
                            </a>
                            @else
                            <a href="{{ route('actividades.edit', $actividad->id) }}"
                                class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-10 rounded-xl shadow-lg">
                                Editar Actividad
                            </a>
                            @endif
                        </div>
                    </form>
                    @endif {{-- Fin de if session success --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>