<x-app-layout>
    {{-- Slot del Header: Esto rellena la barra superior que se ve vacía en tu captura --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ $oper == 'create' ? 'Crear Nuevo Usuario' : ($oper == 'edit' ? 'Editar Usuario' : 'Detalles del
                Usuario') }}
            </h2>
            <a href="{{ route('usuarios.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">

                {{-- Encabezado interno de la tarjeta --}}
                <div class="px-8 py-6 border-b border-gray-50 bg-gradient-to-r from-white to-gray-50/50">
                    <p class="text-gray-600 font-medium">
                        {{ $oper == 'show' ? 'Información completa del registro seleccionado.' : 'Por favor, rellena el
                        formulario para gestionar el usuario.' }}
                    </p>
                </div>

                <div class="p-8">
                    {{-- Alerta de Errores --}}
                    @if ($errors->any())
                    <div class="flex p-4 mb-8 text-sm text-red-800 border-l-4 border-red-500 bg-red-50 rounded-r-xl"
                        role="alert">
                        <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <span class="font-bold">Revisa los siguientes campos:</span>
                            <ul class="mt-1.5 ml-4 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <form
                        action="{{ $oper == 'create' ? route('usuarios.store') : route('usuarios.update', $usuario->id) }}"
                        method="POST">
                        @csrf
                        @if($oper == 'edit') @method('PUT') @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">

                            {{-- Estilo común para inputs --}}
                            @php
                            $inputClasses = "mt-2 block w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl shadow-sm
                            focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all
                            duration-200 placeholder-gray-400";
                            $labelClasses = "block text-sm font-bold text-gray-700 tracking-wide ml-1";
                            @endphp

                            {{-- Nombre --}}
                            <div class="relative">
                                <label class="{{ $labelClasses }}">Nombre Completo</label>
                                <input type="text" name="name" value="{{ old('name', $usuario->name) }}"
                                    class="{{ $inputClasses }} {{ $oper=='show' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                    {{ $oper=='show' ? 'disabled' : 'required' }} placeholder="Ej. Juan Pérez">
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="{{ $labelClasses }}">Correo Electrónico</label>
                                <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                                    class="{{ $inputClasses }} {{ $oper=='show' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                    {{ $oper=='show' ? 'disabled' : 'required' }} placeholder="usuario@correo.com">
                            </div>

                            {{-- Fecha de Nacimiento --}}
                            <div>
                                <label class="{{ $labelClasses }}">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento"
                                    value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento ? \Carbon\Carbon::parse($usuario->fecha_nacimiento)->format('Y-m-d') : '') }}"
                                    class="{{ $inputClasses }} {{ $oper=='show' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                    {{ $oper=='show' ? 'disabled' : 'required' }}>
                            </div>

                            {{-- Género --}}
                            <div>
                                <label class="{{ $labelClasses }}">Género</label>
                                <select name="genero"
                                    class="{{ $inputClasses }} {{ $oper=='show' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                    {{ $oper=='show' ? 'disabled' : 'required' }}>
                                    <option value="" disabled {{ old('genero', $usuario->genero) == '' ? 'selected' : ''
                                        }}>Seleccione...</option>
                                    <option value="hombre" {{ old('genero', $usuario->genero) == 'hombre' ? 'selected' :
                                        '' }}>Hombre</option>
                                    <option value="mujer" {{ old('genero', $usuario->genero) == 'mujer' ? 'selected' :
                                        '' }}>Mujer</option>
                                </select>
                            </div>

                            {{-- Teléfono --}}
                            <div>
                                <label class="{{ $labelClasses }}">Teléfono</label>
                                <input type="text" name="numero_telefono"
                                    value="{{ old('numero_telefono', $usuario->numero_telefono) }}"
                                    class="{{ $inputClasses }} {{ $oper=='show' ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                    {{ $oper=='show' ? 'disabled' : 'required' }} placeholder="+34 000 000 000">
                            </div>

                            {{-- Contraseña --}}
                            @if($oper != 'show')
                            <div>
                                <label class="{{ $labelClasses }}">
                                    Contraseña {{ $oper == 'edit' ? '(Opcional)' : '' }}
                                </label>
                                <input type="password" name="password" class="{{ $inputClasses }}" {{ $oper=='create'
                                    ? 'required' : '' }} placeholder="••••••••">
                            </div>
                            @endif
                        </div>

                        {{-- Footer del Formulario --}}
                        <div class="mt-12 pt-8 border-t border-gray-100 flex justify-end">
                            @if($oper != 'show')
                            <button type="submit"
                                class="group relative inline-flex items-center justify-center px-10 py-3.5 font-bold text-white transition-all duration-200 bg-indigo-600 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200">
                                {{ $oper == 'create' ? 'Crear Usuario' : 'Actualizar Usuario' }}
                                <svg class="w-5 h-5 ml-2 -mr-1 transition-all duration-200 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                            @else
                            <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                class="inline-flex items-center px-10 py-3.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-amber-100">
                                Editar Perfil
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>