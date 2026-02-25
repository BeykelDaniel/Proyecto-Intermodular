<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Tenderete')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/d42bf2e593.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body class="bg-gray-100 antialiased font-sans">

    @include('navbar')

    <main class="container mx-auto mt-8 px-4 min-h-screen">

        {{-- Inyectamos el contenido de cada vista (Login, Registro, Usuarios...) --}}
        @yield('contenido')

    </main>

    <footer class="py-6 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} Tenderete - Todos los derechos reservados.
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Mensaje de Éxito (Verde)
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación realizada!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#1e293b', // Color azul oscuro de tu botón de login
                    timer: 3500,
                    timerProgressBar: true
                });
            @endif

            // 2. Errores de Validación (Rojo)
            @if ($errors -> any())
                Swal.fire({
                    icon: 'error',
                    title: 'Hay errores en el formulario',
                    html: `
                        <div class="text-left mt-2 px-4">
                            <ul class="list-disc text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    `,
                    confirmButtonColor: '#bc6a50', // Color teja de tu botón de registro
                });
            @endif
        });
    </script>

    @stack('scripts')

</body>

</html>