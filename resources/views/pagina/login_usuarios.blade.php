@extends('layout')

@section('title', 'Login')

@section('contenido')
<div class="flex flex-col md:flex-row gap-8 w-full max-w-6xl mx-auto py-8">

    {{-- BLOQUE IZQUIERDA: LOGIN --}}
    <div class="flex-1 bg-white rounded-2xl shadow-xl p-8 border-t-8 border-[#1e293b]">
        <h2 class="text-3xl font-bold text-[#1e293b] mb-8">Ya estoy registrado</h2>

        <form action="{{ route('login.custom') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-600 uppercase mb-2">Correo Electrónico</label>
                <input type="email" name="email" required placeholder="ejemplo@comco.com"
                    class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1e293b] outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-600 uppercase mb-2">Contraseña</label>
                <input type="password" name="password" required placeholder="********"
                    class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1e293b] outline-none">
            </div>

            <button type="submit"
                class="w-full bg-[#1e293b] text-white font-bold py-4 rounded-xl hover:bg-slate-800 transition-all shadow-lg uppercase tracking-widest">
                Entrar a mi cuenta
            </button>
        </form>
    </div>

    {{-- BLOQUE DERECHA: REGISTRO --}}
    <div class="flex-1 bg-white rounded-2xl shadow-xl p-8 border-t-8 border-[#bc6a50]">
        <h2 class="text-3xl font-bold text-[#bc6a50] mb-8">Quiero registrarme</h2>

        <form action="{{ route('usuarios.store_publico') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-600 uppercase mb-1">Nombre Completo</label>
                <input type="text" name="name" required placeholder="Nombres y Apellidos"
                    class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#bc6a50] outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-600 uppercase mb-1">Correo Electrónico</label>
                <input type="email" name="email" required placeholder="ejemplo@correo.com"
                    class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#bc6a50] outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-600 uppercase mb-1">F. Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" required
                        class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#bc6a50] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-600 uppercase mb-1">Género</label>
                    <select name="genero" required
                        class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#bc6a50] outline-none">
                        <option value="hombre">Hombre</option>
                        <option value="mujer">Mujer</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-600 uppercase mb-1">Teléfono</label>
                    <input type="text" name="numero_telefono" required placeholder="600 000 000"
                        class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#bc6a50] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-600 uppercase mb-1">Contraseña</label>
                    <input type="password" name="password" required placeholder="Mín. 8 carac."
                        class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#bc6a50] outline-none">
                </div>
            </div>

            <button type="submit"
                class="w-full mt-4 border-2 border-black text-black font-black py-4 rounded-xl hover:bg-black hover:text-white transition-all uppercase tracking-widest">
                Crear nueva cuenta
            </button>
        </form>
    </div>
</div>
@endsection