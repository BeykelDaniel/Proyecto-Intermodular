@extends('layout')

@section('title', 'Mis Ajustes - Tenderete')

@section('contenido')
<div class="max-w-5xl mx-auto py-8 md:py-16 px-4">
    {{-- Cabecera Premium --}}
    <div class="flex flex-col md:flex-row items-center justify-between mb-10 md:mb-16 gap-6 md:gap-8">
        <div class="flex items-center gap-6 md:gap-8 text-center md:text-left flex-col md:flex-row w-full md:w-auto">
            <div class="relative group">
                <img src="{{ Auth::user()->perfil_foto ? asset(Auth::user()->perfil_foto) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&size=128&background=32424D&color=fff' }}" 
                     class="w-32 h-32 md:w-40 md:h-40 rounded-[35px] md:rounded-[45px] object-cover border-8 border-white shadow-2xl transition-transform duration-500 group-hover:scale-105">
                <div class="absolute -bottom-1 -right-1 w-10 h-10 md:w-12 md:h-12 bg-green-500 border-4 md:border-8 border-white rounded-full shadow-lg"></div>
            </div>
            <div class="flex-1">
                <h1 class="text-3xl md:text-5xl font-black text-[#32424D] uppercase tracking-tighter mb-1 md:mb-2">Mis Ajustes</h1>
                <p class="text-lg md:text-2xl text-[#bc6a50] font-bold italic">Tu experiencia en Tenderete</p>
            </div>
        </div>
        
        <a href="{{ route('pagina.inicio') }}" class="w-full md:w-auto bg-white text-[#32424D] border-4 border-[#32424D] font-black px-8 py-4 rounded-3xl hover:bg-gray-50 transition-all shadow-lg flex items-center justify-center gap-3 text-sm md:text-base">
            <i class="bi bi-arrow-left text-xl"></i>
            VOLVER AL INICIO
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        {{-- COLUMNA IZQUIERDA: DATOS --}}
        <div class="lg:col-span-2 space-y-12">
            <div class="bg-white rounded-[40px] md:rounded-[50px] shadow-xl p-6 md:p-10 border-2 border-gray-100 relative overflow-hidden text-left">
                <div class="absolute top-0 left-0 w-2 h-full bg-[#32424D]"></div>
                
                <div class="flex items-center gap-4 md:gap-5 mb-8 md:mb-10">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-[#32424D]/5 text-[#32424D] rounded-2xl md:rounded-3xl flex items-center justify-center">
                        <i class="bi bi-person-lines-fill text-2xl md:text-3xl"></i>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-black text-[#32424D] uppercase tracking-tight">Información Personal</h2>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 md:space-y-10">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10">
                        <div class="space-y-2 md:space-y-3">
                            <label class="block text-[10px] md:text-sm font-black text-gray-400 uppercase tracking-widest ml-4">Tu Nombre</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                                   class="w-full p-4 md:p-6 bg-gray-50 border-2 border-transparent focus:border-[#32424D] focus:bg-white rounded-[20px] md:rounded-[30px] outline-none font-bold text-lg md:text-xl transition-all shadow-inner">
                        </div>
                        <div class="space-y-2 md:space-y-3">
                            <label class="block text-[10px] md:text-sm font-black text-gray-400 uppercase tracking-widest ml-4">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                                   class="w-full p-4 md:p-6 bg-gray-50 border-2 border-transparent focus:border-[#32424D] focus:bg-white rounded-[20px] md:rounded-[30px] outline-none font-bold text-lg md:text-xl transition-all shadow-inner">
                        </div>
                    </div>

                    <div class="space-y-2 md:space-y-3">
                        <label class="block text-[10px] md:text-sm font-black text-gray-400 uppercase tracking-widest ml-4">Sobre ti (Biografía)</label>
                        <textarea name="biografia" rows="4" 
                                  class="w-full p-4 md:p-6 bg-gray-50 border-2 border-transparent focus:border-[#32424D] focus:bg-white rounded-[20px] md:rounded-[30px] outline-none font-bold text-lg md:text-xl transition-all shadow-inner resize-none"
                                  placeholder="Escribe algo sobre ti...">{{ old('biografia', Auth::user()->biografia) }}</textarea>
                    </div>

                    <div class="pt-4 md:pt-6">
                        <button type="submit" class="w-full bg-[#32424D] text-[#E8D258] font-black py-4 md:py-6 rounded-2xl md:rounded-3xl hover:scale-[1.02] active:scale-95 transition-all shadow-xl uppercase tracking-widest text-lg md:text-xl flex items-center justify-center gap-4">
                            <i class="bi bi-check-circle-fill text-xl md:text-2xl"></i>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

           

        {{-- COLUMNA DERECHA: FOTO Y FUENTE --}}
        <div class="space-y-12">
            {{-- FOTO DE PERFIL --}}
            <div class="bg-white rounded-[50px] shadow-xl p-10 border-2 border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-full h-2 bg-[#bc6a50]"></div>
                
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 bg-[#bc6a50]/5 text-[#bc6a50] rounded-2xl flex items-center justify-center">
                        <i class="bi bi-camera-fill text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-black text-[#32424D] uppercase tracking-tight">Tu Foto</h2>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="remove_photo" id="remove_photo_input" value="0">
                    
                    <div class="space-y-8 text-center">
                        <div class="relative inline-block mx-auto group">
                            <img src="{{ Auth::user()->perfil_foto ? asset(Auth::user()->perfil_foto) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&size=128' }}" 
                                 id="preview-photo"
                                 class="w-48 h-48 rounded-[40px] object-cover border-4 border-gray-100 shadow-lg mx-auto transition-all">
                            
                            <label class="absolute -bottom-4 -right-4 bg-[#32424D] text-white p-4 rounded-2xl shadow-xl cursor-pointer hover:scale-110 active:scale-95 transition-all">
                                <i class="bi bi-upload text-xl"></i>
                                <input type="file" name="perfil_foto" class="hidden" accept="image/*" onchange="previewImage(this)">
                            </label>
                        </div>

                        <div class="flex flex-col gap-4">
                            <button type="button" @if(!Auth::user()->perfil_foto) disabled @endif
                                    onclick="borrarFoto()"
                                    class="w-full py-4 border-2 border-red-200 text-red-500 font-black rounded-2xl hover:bg-red-50 disabled:opacity-30 disabled:hover:bg-transparent transition-all uppercase tracking-tighter text-sm">
                                Quitar foto actual
                            </button>
                            <button type="submit" class="w-full py-4 bg-[#bc6a50] text-white font-black rounded-2xl hover:scale-105 active:scale-95 transition-all shadow-lg uppercase tracking-widest text-sm">
                                Actualizar Foto
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- TAMAÑO DE LETRA --}}
            <div class="bg-white rounded-[40px] md:rounded-[50px] shadow-xl p-6 md:p-10 border-2 border-gray-100 relative overflow-hidden">
                <div class="absolute bottom-0 left-0 w-full h-2 bg-[#E8D258]"></div>
                
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-[#E8D258]/10 text-[#C2841D] rounded-xl md:rounded-2xl flex items-center justify-center">
                        <i class="bi bi-fonts text-xl md:text-2xl"></i>
                    </div>
                    <h2 class="text-xl md:text-2xl font-black text-[#32424D] uppercase tracking-tight">Letra Web</h2>
                </div>

                <form action="{{ route('profile.updateFontSize') }}" method="POST" class="space-y-8 md:space-y-10">
                    @csrf
                    <div class="px-2">
                        <input type="range" name="font_size" min="1" max="5" value="{{ Auth::user()->font_size ?? 3 }}" 
                               class="w-full h-6 md:h-4 bg-gray-100 rounded-full appearance-none cursor-pointer accent-[#C2841D]"
                               oninput="liveFontSizeUpdate(this.value)">
                        
                        <div class="flex justify-between mt-4 md:mt-6">
                            <div class="flex flex-col items-center">
                                <span class="bg-gray-100 p-1 md:p-2 rounded-lg text-[9px] md:text-xs font-black text-gray-400 mb-1 md:mb-2 uppercase">Min</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="bg-gray-100 p-1 md:p-2 rounded-lg text-[9px] md:text-xs font-black text-[#C2841D] mb-1 md:mb-2 uppercase">Defecto</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="bg-gray-100 p-1 md:p-2 rounded-lg text-[9px] md:text-xs font-black text-gray-400 mb-1 md:mb-2 uppercase">Max</span>
                            </div>
                        </div>
                    </div>

                    <div id="text-preview" class="p-4 md:p-6 bg-gray-50 rounded-[20px] md:rounded-[30px] border-2 border-gray-100 text-center italic text-[#32424D] font-bold text-sm md:text-base">
                        "En Tenderete nos cuidamos y disfrutamos juntos."
                    </div>

                    <button type="submit" class="w-full bg-[#E8D258] text-[#32424D] font-black py-4 rounded-2xl hover:scale-105 active:scale-95 transition-all shadow-lg uppercase tracking-widest text-sm">
                        Aplicar a toda la web
                    </button>
                </form>
                
            </div>
            {{-- ZONA DE PELIGRO --}}
            <div class="bg-red-50/50 rounded-[50px] p-10 border-4 border-dashed border-red-100 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="text-center md:text-left">
                    <h3 class="text-2xl font-black text-red-800 uppercase mb-2">¿Quieres dejarnos?</h3>
                    <p class="text-lg font-bold text-red-700/60 leading-tight">Borrar tu cuenta es permanente y borrará todos tus datos, fotos y amigos.</p>
                </div>
                <button onclick="confirmarEliminar()" class="bg-red-600 text-white font-black px-10 py-5 rounded-3xl hover:bg-red-700 transition-all shadow-lg uppercase tracking-tight whitespace-nowrap">
                    Eliminar mi cuenta
                </button>
            </div>
        </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-photo').src = e.target.result;
                document.getElementById('remove_photo_input').value = "0";
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function borrarFoto() {
        document.getElementById('preview-photo').src = "https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=128&background=gray&color=fff";
        document.getElementById('remove_photo_input').value = "1";
    }

    function liveFontSizeUpdate(val) {
        const sizes = {
            1: '14px',
            2: '16px',
            3: '18px',
            4: '21px',
            5: '24px'
        };
        const newSize = sizes[val];
        document.documentElement.style.setProperty('--app-font-size', newSize);
        // El preview se actualiza automáticamente porque usa 1rem, pero forzamos por si acaso
        document.getElementById('text-preview').style.fontSize = '1.2rem'; 
    }

    function confirmarEliminar() {
        Swal.fire({
            title: '¿De verdad quieres irte?',
            text: "Perderás todos tus amigos y actividades. Esta acción es definitiva.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#32424D',
            confirmButtonText: 'Sí, borrar mi cuenta',
            cancelButtonText: 'No, me quedo'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Por seguridad, escribe tu contraseña',
                    input: 'password',
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar ahora',
                    confirmButtonColor: '#d33'
                }).then((res) => {
                    if (res.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = "{{ route('profile.destroy') }}";
                        form.innerHTML = `
                            @csrf
                            @method('delete')
                            <input type="hidden" name="password" value="${res.value}">
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                })
            }
        })
    }
</script>

<style>
    /* Estilos extra para el slider personalizado si fuese necesario */
    input[type=range]::-webkit-slider-thumb {
        width: 24px;
        height: 24px;
        border: 4px solid white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
</style>
@endsection
