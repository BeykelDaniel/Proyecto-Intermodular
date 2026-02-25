@extends('layout')

@section('title', $oper == 'create' ? 'Crear Actividad - Tenderete' : 'Editar Actividad')

@section('contenido')
<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden border-4 border-[#32424D]/10">
        
        {{-- CABECERA CÁLIDA --}}
        <div class="bg-[#bc6a50] p-10 text-white flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black uppercase tracking-tight mb-2">
                    {{ $oper == 'create' ? 'Nueva Actividad' : 'Modificar Actividad' }}
                </h1>
                <p class="text-lg font-bold opacity-80 italic">Cuéntanos qué plan tienes en mente para hoy.</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                <i class="bi bi-calendar-plus text-4xl"></i>
            </div>
        </div>

        <div class="p-10">
            @if (session('success'))
                <div class="text-center py-10">
                    <div class="w-24 h-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner animate-bounce">
                        <i class="bi bi-check-lg text-6xl"></i>
                    </div>
                    <h3 class="text-3xl font-black text-[#32424D] uppercase mb-4">{{ session('success') }}</h3>
                    <p class="text-xl text-gray-400 font-bold mb-10 leading-relaxed italic">¡Genial! La actividad ya está publicada y los demás podrán verla.</p>
                    <a href="{{ route('pagina.inicio') }}" class="inline-block bg-[#32424D] text-white font-black py-5 px-12 rounded-3xl shadow-xl hover:scale-105 transition-transform uppercase tracking-widest text-lg">
                        <i class="bi bi-house-door-fill mr-4"></i> Volver al Inicio
                    </a>
                </div>
            @else
                
                @if ($errors->any())
                    <div class="mb-10 p-6 bg-red-50 border-l-8 border-red-500 rounded-2xl">
                        <p class="text-lg font-black text-red-800 uppercase mb-2">Por favor, revisa esto:</p>
                        <ul class="list-disc ml-6 text-red-700 font-bold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ $oper == 'create' ? route('actividades.store') : route('actividades.update', $actividad->id) }}"
                      method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf
                    @if($oper == 'edit') @method('PUT') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        @php
                            $inputClasses = "w-full p-5 bg-gray-50 border-2 border-gray-100 rounded-3xl focus:bg-white focus:border-[#bc6a50] focus:ring-8 focus:ring-[#bc6a50]/10 outline-none transition-all text-lg font-bold";
                            $labelClasses = "block text-sm font-black text-gray-400 uppercase tracking-widest ml-4 mb-3";
                        @endphp

                        {{-- 0. IMAGEN --}}
                        <div class="col-span-full">
                            <label class="{{ $labelClasses }}">Foto de la Actividad</label>
                            <div class="flex items-center gap-6 p-6 bg-orange-50/30 rounded-[35px] border-2 border-dashed border-[#bc6a50]/20">
                                <div class="w-32 h-32 bg-white border-2 border-orange-100 rounded-3xl overflow-hidden flex items-center justify-center text-[#bc6a50]/30 shadow-sm shrink-0">
                                    @if(isset($actividad->imagen))
                                        <img src="{{ asset($actividad->imagen) }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="bi bi-camera-fill text-5xl"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="imagen" accept="image/*" class="w-full text-sm font-bold text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-black file:bg-[#bc6a50] file:text-white hover:file:bg-[#8e4f3c] cursor-pointer" {{ $oper=='show' ? 'disabled' : '' }}>
                                    <p class="text-xs text-gray-400 mt-3 font-bold italic">Si no tienes foto, pondremos una bonita automáticamente.</p>
                                </div>
                            </div>
                        </div>

                        {{-- 1. NOMBRE --}}
                        <div class="col-span-full">
                            <label class="{{ $labelClasses }}">¿Cómo se llama la actividad?</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $actividad->nombre ?? '') }}"
                                   class="{{ $inputClasses }}" {{ $oper=='show' ? 'disabled' : 'required' }}
                                   placeholder="Ej. Taller de Cerámica o Paseo por el Retiro">
                        </div>

                        {{-- 2. DESCRIPCIÓN --}}
                        <div class="col-span-full">
                            <label class="{{ $labelClasses }}">Cuéntanos un poco más</label>
                            <textarea name="descripcion" rows="3" class="{{ $inputClasses }}" {{ $oper=='show' ? 'disabled' : 'required' }}
                                      placeholder="Escribe aquí de qué trata el plan...">{{ old('descripcion', $actividad->descripcion ?? '') }}</textarea>
                        </div>

                        {{-- 3. FECHA --}}
                        <div class="space-y-2">
                            <label class="{{ $labelClasses }}">¿Qué día es?</label>
                            <input type="date" name="fecha"
                                   value="{{ old('fecha', isset($actividad->fecha) ? \Carbon\Carbon::parse($actividad->fecha)->format('Y-m-d') : '') }}"
                                   class="{{ $inputClasses }}" {{ $oper=='show' ? 'disabled' : 'required' }}>
                        </div>

                        {{-- 4. HORA --}}
                        <div class="space-y-2">
                            <label class="{{ $labelClasses }}">¿A qué hora empieza?</label>
                            <input type="time" name="hora" value="{{ old('hora', $actividad->hora ?? '') }}"
                                   class="{{ $inputClasses }}" {{ $oper=='show' ? 'disabled' : 'required' }}>
                        </div>

                        {{-- 5. LUGAR --}}
                        <div class="col-span-full">
                            <label class="{{ $labelClasses }}">¿Dónde nos vemos?</label>
                            <input type="text" name="lugar" value="{{ old('lugar', $actividad->lugar ?? '') }}"
                                   class="{{ $inputClasses }}" {{ $oper=='show' ? 'disabled' : 'required' }}
                                   placeholder="Ej. Centro Cultural, Parque, Plaza...">
                        </div>

                        <div class="space-y-2">
                            <label class="{{ $labelClasses }}">Precio (€)</label>
                            <input type="number" step="0.01" name="precio" value="{{ old('precio', $actividad->precio ?? '0.00') }}"
                                   class="{{ $inputClasses }}" placeholder="0.00" {{ $oper=='show' ? 'disabled' : '' }}>
                        </div>

                        <div class="space-y-2">
                            <label class="{{ $labelClasses }}">Cupos (Plazas)</label>
                            <input type="number" name="cupos" value="{{ old('cupos', $actividad->cupos ?? '50') }}"
                                   class="{{ $inputClasses }}" placeholder="Ej. 20" {{ $oper=='show' ? 'disabled' : '' }}>
                        </div>
                    </div>

                    {{-- BOTONES FINALES --}}
                    <div class="mt-16 flex flex-col md:flex-row gap-4 pt-10 border-t-4 border-gray-50">
                        <button type="submit" class="flex-1 bg-[#bc6a50] text-white font-black py-6 rounded-[30px] shadow-2xl hover:bg-[#8e4f3c] hover:scale-[1.02] active:scale-95 transition-all uppercase tracking-widest text-xl">
                            {{ $oper == 'create' ? 'Crear Actividad Ahora' : 'Guardar Cambios' }}
                        </button>
                        <a href="{{ route('pagina.inicio') }}" class="px-12 py-6 bg-gray-100 text-gray-400 font-black rounded-[30px] hover:bg-gray-200 transition-all uppercase tracking-widest text-center">
                            Cancelar
                        </a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection