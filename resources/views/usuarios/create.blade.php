<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $oper == 'create' ? 'Crear Usuario' : ($oper == 'edit' ? 'Editar Usuario' : 'Ver Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ $oper == 'create' ? route('usuarios.store') : route('usuarios.update', $usuario->id) }}" method="POST">
                    @csrf
                    @if($oper != 'create')
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $usuario->name) }}"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"
                            {{ $oper=='show' ? 'disabled' : '' }}>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"
                            {{ $oper=='show' ? 'disabled' : '' }}>
                    </div>

                    <div class="mb-4">
                        <label for="fecha_nacimiento" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Nacimiento:</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                            value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento ? \Carbon\Carbon::parse($usuario->fecha_nacimiento)->format('Y-m-d') : '') }}"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"
                            {{ $oper=='show' ? 'disabled' : '' }}>
                    </div>

                    <div class="mb-4">
                        <label for="genero" class="block text-gray-700 text-sm font-bold mb-2">Género:</label>
                        <select name="genero" id="genero"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"
                            {{ $oper=='show' ? 'disabled' : '' }}>
                            <option value="">Seleccione...</option>
                            <option value="hombre" {{ old('genero', $usuario->genero) == 'hombre' ? 'selected' : '' }}>Hombre</option>
                            <option value="mujer" {{ old('genero', $usuario->genero) == 'mujer' ? 'selected' : '' }}>Mujer</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="numero_telefono" class="block text-gray-700 text-sm font-bold mb-2">Teléfono:</label>
                        <input type="text" name="numero_telefono" id="numero_telefono"
                            value="{{ old('numero_telefono', $usuario->numero_telefono) }}"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"
                            {{ $oper=='show' ? 'disabled' : '' }}>
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                            Contraseña {{ $oper != 'create' ? '(Dejar en blanco para mantener actual)' : '' }}:
                        </label>
                        <input type="password" name="password" id="password"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"
                            {{ $oper=='show' ? 'disabled' : '' }}>
                    </div>

                    <div class="flex items-center justify-between">
                        @if($oper != 'show')
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ $oper == 'create' ? 'Guardar' : 'Actualizar' }}
                        </button>
                        @endif
                        <a href="{{ route('usuarios.index') }}" class="text-blue-500 hover:text-blue-800 font-bold">
                            Cancelar / Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
