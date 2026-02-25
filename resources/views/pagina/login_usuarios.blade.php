@extends('layout')

@section('title', 'Bienvenido a Tenderete')

@section('contenido')
<div class="max-w-6xl mx-auto py-12 px-4">
    <div class="text-center mb-16">
        <h1 class="text-5xl font-black text-[#32424D] mb-4 uppercase tracking-tighter">¡Hola de nuevo!</h1>
        <p class="text-xl text-gray-500 font-medium">Entra en tu comunidad o crea una cuenta nueva en un minuto.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-12 items-start">

        {{-- BLOQUE LOGIN: MÁS ACCESIBLE --}}
        <div class="w-full lg:w-5/12 bg-white rounded-[40px] shadow-2xl p-10 border-4 border-[#32424D]/10">
            <div class="flex items-center gap-4 mb-10">
                <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="bi bi-person-check-fill text-3xl"></i>
                </div>
                <h2 class="text-3xl font-black text-[#32424D] uppercase">Ya soy parte</h2>
            </div>

            <form action="{{ route('login.custom') }}" method="POST" class="space-y-8">
                @csrf
                <div class="space-y-3">
                    <label class="block text-lg font-bold text-gray-700 ml-2 italic underline decoration-indigo-300 decoration-4">Tu Correo Electrónico</label>
                    <input type="email" name="email" required placeholder="ejemplo@correo.com"
                        class="w-full p-5 bg-gray-50 border-2 border-gray-100 rounded-3xl focus:bg-white focus:border-indigo-500 focus:ring-8 focus:ring-indigo-100 outline-none transition-all text-lg font-bold">
                </div>

                <div class="space-y-3">
                    <label class="block text-lg font-bold text-gray-700 ml-2 italic underline decoration-indigo-300 decoration-4">Tu Contraseña</label>
                    <input type="password" name="password" required placeholder="Tu clave secreta"
                        class="w-full p-5 bg-gray-50 border-2 border-gray-100 rounded-3xl focus:bg-white focus:border-indigo-500 focus:ring-8 focus:ring-indigo-100 outline-none transition-all text-lg font-bold">
                </div>

                <button type="submit"
                    class="w-full bg-[#32424D] text-white font-black py-6 rounded-3xl hover:bg-black hover:scale-[1.02] active:scale-95 transition-all shadow-xl uppercase tracking-widest text-xl flex items-center justify-center gap-4">
                    Entrar ahora <i class="bi bi-arrow-right-circle-fill"></i>
                </button>
            </form>
        </div>

        {{-- DIVIDOR VISUAL --}}
        <div class="hidden lg:flex flex-col items-center justify-center h-full py-20 grayscale opacity-20">
            <div class="w-1 h-32 bg-gray-400 rounded-full"></div>
            <span class="my-4 font-black text-2xl uppercase">O</span>
            <div class="w-1 h-32 bg-gray-400 rounded-full"></div>
        </div>

        {{-- BLOQUE REGISTRO: MÁS CÁLIDO --}}
        <div class="w-full lg:flex-1 bg-white rounded-[40px] shadow-2xl p-10 border-4 border-[#bc6a50]/10">
             <div class="flex items-center gap-4 mb-10">
                <div class="w-16 h-16 bg-orange-100 text-[#bc6a50] rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="bi bi-person-plus-fill text-3xl"></i>
                </div>
                <h2 class="text-3xl font-black text-[#bc6a50] uppercase">Quiero unirme</h2>
            </div>

            <form action="{{ route('usuarios.store_publico') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @csrf
                <div class="col-span-full">
                    <label class="block text-lg font-bold text-gray-700 ml-2 mb-3 italic underline decoration-orange-300 decoration-4">Foto de Perfil (Opcional)</label>
                    <div class="flex items-center gap-6 p-4 bg-orange-50/30 rounded-3xl border-2 border-dashed border-orange-200">
                        <div class="w-20 h-20 bg-white border-2 border-orange-100 rounded-2xl flex items-center justify-center text-orange-300">
                            <i class="bi bi-camera-fill text-3xl"></i>
                        </div>
                        <input type="file" name="perfil_foto" accept="image/*" class="flex-1 text-sm font-bold text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                    </div>
                </div>

                <div class="col-span-full">
                    <label class="block text-sm font-black text-gray-500 uppercase tracking-widest ml-2 mb-2">Nombre Completo</label>
                    <input type="text" name="name" required placeholder="¿Cómo te llamas?"
                        class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-orange-500 focus:ring-8 focus:ring-orange-50/50 outline-none transition-all font-bold">
                </div>

                <div class="col-span-full">
                    <label class="block text-sm font-black text-gray-500 uppercase tracking-widest ml-2 mb-2">Correo Electrónico</label>
                    <input type="email" name="email" required placeholder="tu@correo.com"
                        class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-orange-500 focus:ring-8 focus:ring-orange-50/50 outline-none transition-all font-bold">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-black text-gray-500 uppercase tracking-widest ml-2">¿Cuándo naciste?</label>
                    <input type="date" name="fecha_nacimiento" required
                        class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-orange-500 outline-none font-bold">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-black text-gray-500 uppercase tracking-widest ml-2">Género</label>
                    <select name="genero" required
                        class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-orange-500 outline-none font-bold">
                        <option value="hombre">Hombre</option>
                        <option value="mujer">Mujer</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-black text-gray-500 uppercase tracking-widest ml-2">Teléfono</label>
                    <input type="text" name="numero_telefono" required placeholder="600 000 000"
                        class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-orange-500 outline-none font-bold">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-black text-gray-500 uppercase tracking-widest ml-2">Contraseña</label>
                    <input type="password" name="password" required placeholder="Mínimo 8 letras"
                        class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-orange-500 outline-none font-bold">
                </div>

                <button type="submit"
                    class="col-span-full mt-6 bg-[#bc6a50] text-white font-black py-5 rounded-3xl hover:bg-orange-800 hover:scale-[1.02] active:scale-95 transition-all shadow-xl uppercase tracking-widest text-lg">
                    Comenzar mi aventura
                </button>
            </form>
        </div>
    </div>
</div>
@endsection