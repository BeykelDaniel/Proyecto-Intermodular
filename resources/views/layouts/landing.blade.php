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
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-100 antialiased font-sans">

    {{-- Layout sin Navbar para la portada promocional --}}

    <main class="container mx-auto px-4 min-h-screen py-8">
        @yield('contenido')
    </main>

    <footer class="py-12 text-center text-gray-500 text-lg">
        <div class="mb-6">
            <img src="{{ asset('logo.png') }}" class="h-16 inline-block mb-4 grayscale" alt="Logo">
            <p>&copy; {{ date('Y') }} Tenderete - Todos los derechos reservados.</p>
        </div>
        <div class="flex justify-center gap-6">
            <a href="#" class="hover:text-[#bc6a50]">Términos</a>
            <a href="#" class="hover:text-[#bc6a50]">Privacidad</a>
            <a href="#" class="hover:text-[#bc6a50]">Soporte</a>
        </div>
    </footer>

    @stack('scripts')

</body>

</html>
