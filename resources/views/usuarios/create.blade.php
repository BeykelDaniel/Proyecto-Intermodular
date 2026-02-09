<<<<<<< HEAD
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $oper == 'create' ? 'Crear Usuario' : ($oper == 'edit' ? 'Editar Usuario' : 'Ver Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
=======
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl mt-10">
        <div class="md:flex">
            <div class="p-8 w-full">
                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold mb-4">
                    @if($oper == 'create') Crear Usuario @elseif($oper == 'edit') Editar Usuario @else Ver Usuario
                    @endif
                </div>

>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

<<<<<<< HEAD
                <form action="{{ $oper == 'create' ? route('usuarios.store') : route('usuarios.update', $usuario->id) }}" method="POST">
                    @csrf
                    @if($oper != 'create')
                        @method('PUT')
=======
                <form
                    action="{{ $oper == 'create' ? route('usuarios.store') : route('usuarios.update', $usuario->id) }}"
                    method="POST">
                    @csrf
                    @if($oper != 'create')
                    @method('PUT')
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
                    @endif

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $usuario->name) }}"
<<<<<<< HEAD
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"
=======
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
                            {{ $oper=='show' ? 'disabled' : '' }}>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}"
<<<<<<< HEAD
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"
=======
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
                            {{ $oper=='show' ? 'disabled' : '' }}>
                    </div>

                    <div class="mb-4">
<<<<<<< HEAD
                        <label for="fecha_nacimiento" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Nacimiento:</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                            value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento ? \Carbon\Carbon::parse($usuario->fecha_nacimiento)->format('Y-m-d') : '') }}"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"
=======
                        <label for="fecha_nacimiento" class="block text-gray-700 text-sm font-bold mb-2">Fecha de
                            Nacimiento:</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                            value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento ? $usuario->fecha_nacimiento->format('Y-m-d') : '') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
                            {{ $oper=='show' ? 'disabled' : '' }}>
                    </div>

                    <div class="mb-4">
                        <label for="genero" class="block text-gray-700 text-sm font-bold mb-2">Género:</label>
                        <select name="genero" id="genero"
<<<<<<< HEAD
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"
                            {{ $oper=='show' ? 'disabled' : '' }}>
                            <option value="">Seleccione...</option>
                            <option value="hombre" {{ old('genero', $usuario->genero) == 'hombre' ? 'selected' : '' }}>Hombre</option>
                            <option value="mujer" {{ old('genero', $usuario->genero) == 'mujer' ? 'selected' : '' }}>Mujer</option>
=======
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            {{ $oper=='show' ? 'disabled' : '' }}>
                            <option value="">Seleccione...</option>
                            <option value="hombre" {{ old('genero', $usuario->genero) == 'hombre' ? 'selected' : ''
                                }}>Hombre</option>
                            <option value="mujer" {{ old('genero', $usuario->genero) == 'mujer' ? 'selected' : ''
                                }}>Mujer</option>
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
                        </select>
                    </div>

                    <div class="mb-4">
<<<<<<< HEAD
                        <label for="numero_telefono" class="block text-gray-700 text-sm font-bold mb-2">Teléfono:</label>
                        <input type="text" name="numero_telefono" id="numero_telefono"
                            value="{{ old('numero_telefono', $usuario->numero_telefono) }}"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"
=======
                        <label for="numero_telefono"
                            class="block text-gray-700 text-sm font-bold mb-2">Teléfono:</label>
                        <input type="text" name="numero_telefono" id="numero_telefono"
                            value="{{ old('numero_telefono', $usuario->numero_telefono) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
                            {{ $oper=='show' ? 'disabled' : '' }}>
                    </div>

                    <div class="mb-6">
<<<<<<< HEAD
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                            Contraseña {{ $oper != 'create' ? '(Dejar en blanco para mantener actual)' : '' }}:
                        </label>
                        <input type="password" name="password" id="password"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none"
=======
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña {{ $oper !=
                            'create' ? '(Dejar en blanco para mantener actual)' : '' }}:</label>
                        <input type="password" name="password" id="password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
                            {{ $oper=='show' ? 'disabled' : '' }}>
                    </div>

                    <div class="flex items-center justify-between">
                        @if($oper != 'show')
<<<<<<< HEAD
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ $oper == 'create' ? 'Guardar' : 'Actualizar' }}
                        </button>
                        @endif
                        <a href="{{ route('usuarios.index') }}" class="text-blue-500 hover:text-blue-800 font-bold">
=======
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ $oper == 'create' ? 'Guardar' : 'Actualizar' }}
                        </button>
                        @endif
                        <a href="{{ route('usuarios.index') }}"
                            class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
                            Cancelar / Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<<<<<<< HEAD
</x-app-layout>
=======
</div>
@endsection
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
