<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Editar Usuario') }}: {{ $usuario->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    
                    <form method="POST" action="{{ route('usuarios.update', $usuario) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nombre --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Nombre Completo</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $usuario->name) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Correo Electrónico</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Teléfono --}}
                            <div>
                                <label for="numero_telefono" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Teléfono</label>
                                <input type="text" name="numero_telefono" id="numero_telefono" value="{{ old('numero_telefono', $usuario->numero_telefono) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            {{-- Fecha de Nacimiento --}}
                            <div>
                                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                                    value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento ? \Carbon\Carbon::parse($usuario->fecha_nacimiento)->format('Y-m-d') : '') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            {{-- Género --}}
                            <div>
                                <label for="genero" class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Género</label>
                                <select name="genero" id="genero" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="hombre" {{ old('genero', $usuario->genero) == 'hombre' ? 'selected' : '' }}>Hombre</option>
                                    <option value="mujer" {{ old('genero', $usuario->genero) == 'mujer' ? 'selected' : '' }}>Mujer</option>
                                    <option value="otro" {{ old('genero', $usuario->genero) == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end items-center space-x-3">
                            
                            {{-- Botón Cancelar --}}
                            <a href="{{ route('usuarios.index') }}" 
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