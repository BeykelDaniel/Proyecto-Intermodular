<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tenderete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen">
        <nav class="bg-white border-b border-gray-100 p-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <a href="{{ route('usuarios.index') }}" class="text-xl font-bold text-gray-800">Tenderete</a>
                <div>
                    <a href="{{ route('usuarios.index') }}" class="text-gray-600 hover:text-gray-900 mx-2">Usuarios</a>
                </div>
            </div>
        </nav>

        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>