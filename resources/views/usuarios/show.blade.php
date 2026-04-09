<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Detalles del Usuario') }}: {{ $usuario->name }}
            </h2>
            <a href="{{ route('usuarios.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition ease-in-out duration-150 shadow-sm">
                &larr; Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    {{-- Encabezado del Perfil --}}
                    <div class="flex items-center border-b border-gray-100 pb-6 mb-6">
                        <div class="h-20 w-20 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 shadow-sm">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $usuario->name }}</h3>
                            <p class="text-sm text-gray-500 italic uppercase tracking-wide">
                                Registrado el {{ $usuario->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>

                    {{-- Información en Cuadrícula --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Email --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Correo Electrónico</label>
                            <p class="mt-1 text-lg text-gray-800 font-medium">{{ $usuario->email }}</p>
                        </div>

                        {{-- Teléfono --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Número de Teléfono</label>
                            <p class="mt-1 text-lg text-gray-800 font-medium">{{ $usuario->numero_telefono ?? 'No registrado' }}</p>
                        </div>

                        {{-- Fecha de Nacimiento --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Fecha de Nacimiento</label>
                            <p class="mt-1 text-lg text-gray-800 font-medium">
                                {{ $usuario->fecha_nacimiento ? \Carbon\Carbon::parse($usuario->fecha_nacimiento)->format('d \d\e F, Y') : 'N/A' }}
                            </p>
                        </div>

                        {{-- Género --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Género</label>
                            <div class="mt-1">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 border border-indigo-200">
                                    {{ ucfirst($usuario->genero) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Acciones del Pie --}}
                    <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end items-center space-x-3">
                        
                        {{-- Botón Editar (Verde con ancho fijo) --}}
                        <a href="{{ route('usuarios.edit', $usuario) }}" 
                            class="inline-flex items-center justify-center w-48 h-10 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-150 shadow-sm">
                            Editar Información
                        </a>
                        
                        {{-- Botón Eliminar (Rojo con el mismo ancho fijo) --}}
                        <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" 
                              onsubmit="return confirm('¿Estás seguro de eliminar permanentemente este usuario?')"
                              class="m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="inline-flex items-center justify-center w-48 h-10 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-150 shadow-sm">
                                Eliminar Usuario
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>