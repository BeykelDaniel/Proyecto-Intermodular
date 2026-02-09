@extends('layout')
@section('title', 'Listado de usuarios')
@section('contenido')

<div class="container pt-4">

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Fecha Nacimiento</th>
                <th scope="col">Genero</th>
                <th scope="col">Telefono</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)



            <tr>
                <th>
                    <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-primary"><i
                            class="bi bi-search"></i></a>
                    <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-success"><i
                            class="bi bi-pencil-square"></i></a>
                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </th>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ optional($usuario->fecha_nacimiento)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($usuario->genero) }}</td>
                <td>{{ $usuario->numero_telefono }}</td>
            </tr>
            @endforeach

            {{ $usuarios->links() }}

        </tbody>
    </table>

    <a class="btn btn-primary" href="{{ route('usuarios.create') }}">Nuevo Usuario</a>



</div>

@endsection