@extends('layout')

@section('title', 'Mi Perfil y Configuración')

@section('contenido')
<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="bg-white rounded-[40px] shadow-2xl p-10 border-4 border-[#32424D]/10">
        <div class="flex items-center gap-6 mb-12 border-b-2 border-gray-100 pb-8">
            <div class="relative">
                <img src="{{ Auth::user()->perfil_foto ? '/' . Auth::user()->perfil_foto : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&size=128' }}" 
                     class="w-32 h-32 rounded-[35px] object-cover border-4 border-[#32424D] shadow-xl">
                <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-green-500 border-4 border-white rounded-full"></div>
            </div>
            <div>
                <h1 class="text-4xl font-black text-[#32424D] uppercase tracking-tight">{{ Auth::user()->name }}</h1>
                <p class="text-xl text-gray-400 font-bold italic">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <div class="space-y-12">
            {{-- INFORMACIÓN PERSONAL Y FOTO --}}
            <section>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center shadow-inner">
                        <i class="bi bi-person-fill text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-black text-[#32424D] uppercase tracking-widest">Mis Datos</h2>
                </div>

                <div class="bg-gray-50 rounded-[30px] p-8 border-2 border-gray-100">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-black text-gray-400 uppercase tracking-widest ml-4 mb-3">Nombre</label>
                                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                                       class="w-full p-5 bg-white border-2 border-gray-100 rounded-3xl focus:border-blue-500 outline-none font-bold text-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-black text-gray-400 uppercase tracking-widest ml-4 mb-3">Correo Electrónico</label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                                       class="w-full p-5 bg-white border-2 border-gray-100 rounded-3xl focus:border-blue-500 outline-none font-bold text-lg">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest ml-4 mb-3">Mi Biografía (Sobre mí)</label>
                            <textarea name="biografia" rows="4" 
                                      class="w-full p-5 bg-white border-2 border-gray-100 rounded-3xl focus:border-blue-500 outline-none font-bold text-lg resize-none"
                                      placeholder="Cuéntanos un poco sobre ti...">{{ old('biografia', Auth::user()->biografia) }}</textarea>
                            <p class="text-xs text-gray-400 font-bold uppercase mt-2 ml-4">Este texto aparecerá en tu perfil público.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-400 uppercase tracking-widest ml-4 mb-3">Foto de Perfil</label>
                            <div class="flex items-center gap-6 p-6 bg-white rounded-3xl border-2 border-gray-100">
                                <img src="{{ Auth::user()->perfil_foto ? '/' . Auth::user()->perfil_foto : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                                     class="w-20 h-20 rounded-2xl object-cover border-2 border-gray-100">
                                <input type="file" name="perfil_foto" accept="image/*" class="text-sm font-bold text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white font-black py-5 rounded-3xl hover:bg-blue-700 transition-all shadow-xl uppercase tracking-widest text-lg">
                            Guardar mis datos
                        </button>
                    </form>
                </div>
            </section>

            {{-- CONFIGURACIÓN DE TAMAÑO DE LETRA --}}
            <section>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner">
                        <i class="bi bi-fonts text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-black text-[#32424D] uppercase tracking-widest">Tamaño de Letra</h2>
                </div>
                
                <div class="bg-gray-50 rounded-[30px] p-8 border-2 border-gray-100">
                    <p class="mb-8 text-lg font-bold text-gray-600 leading-relaxed italic">
                        Desliza la barra para elegir un tamaño de letra que te resulte cómodo para leer. ¡Se aplicará a toda la página!
                    </p>

                    <form action="{{ route('profile.updateFontSize') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="px-4">
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-sm font-black text-gray-400 uppercase tracking-widest">Ajustar tamaño</label>
                            </div>
                            <input type="range" name="font_size" min="1" max="5" value="{{ Auth::user()->font_size ?? 3 }}" 
                                   class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600"
                                   oninput="updatePreview(this.value)">
                            <div class="flex justify-between mt-4 px-2">
                                <span class="text-sm font-black text-gray-400 text-xs">PEQUEÑA</span>
                                <span class="text-sm font-black text-gray-400 text-xs">MEDIANA</span>
                                <span class="text-sm font-black text-gray-400 text-xs">MUY GRANDE</span>
                            </div>
                        </div>

                        <div id="font-preview" class="p-8 bg-white rounded-[30px] border-4 border-dashed border-indigo-100 text-center shadow-inner">
                            <p class="font-bold text-[#32424D]">Texto de ejemplo: Así se verá la letra en Tenderete.</p>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white font-black py-5 rounded-3xl hover:bg-indigo-700 transition-all shadow-xl uppercase tracking-widest text-lg">
                            Guardar tamaño de letra
                        </button>
                    </form>
                </div>
            </section>

            {{-- ELIMINAR CUENTA --}}
            <section class="border-t-4 border-red-50 pt-12">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center shadow-inner">
                        <i class="bi bi-person-x-fill text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-black text-[#32424D] uppercase tracking-widest">Zona de Peligro</h2>
                </div>

                <div class="bg-red-50 rounded-[30px] p-8 border-2 border-red-100">
                    <h3 class="text-xl font-black text-red-800 uppercase mb-4">Eliminar mi cuenta</h3>
                    <p class="text-lg font-bold text-red-700/70 mb-8 leading-relaxed">
                        Una vez que elimines tu cuenta, todas tus fotos, mensajes y amistades se borrarán para siempre. Esta acción no se puede deshacer.
                    </p>

                    <button onclick="confirmarEliminar()" class="w-full md:w-auto bg-red-600 text-white font-black py-4 px-10 rounded-2xl hover:bg-red-700 transition-all shadow-lg uppercase tracking-widest text-sm">
                        Eliminar cuenta permanentemente
                    </button>

                    <form id="deleteAccountForm" action="{{ route('profile.destroy') }}" method="POST" class="hidden">
                        @csrf
                        @method('delete')
                        <input type="password" name="password" id="confirm_password">
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    function updatePreview(val) {
        const sizes = {
            1: '14px',
            2: '16px',
            3: '18px',
            4: '21px',
            5: '24px'
        };
        document.getElementById('font-preview').style.fontSize = sizes[val];
    }
    function confirmarEliminar() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción borrará todos tus datos y no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar cuenta',
            cancelButtonText: 'No, quiero quedarme'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Introduce tu contraseña',
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar Eliminación',
                    showLoaderOnConfirm: true,
                    preConfirm: (password) => {
                        if(!password) {
                            Swal.showValidationMessage('La contraseña es necesaria');
                            return;
                        }
                        return password;
                    }
                }).then((res) => {
                    if (res.isConfirmed) {
                        document.getElementById('confirm_password').value = res.value;
                        document.getElementById('deleteAccountForm').submit();
                    }
                })
            }
        })
    }
    // Inicializar
    updatePreview({{ Auth::user()->font_size ?? 3 }});
</script>
@endsection
