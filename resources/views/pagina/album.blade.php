@extends('layout')

@section('contenido')
<div class="container mt-10 bg-[#ebd08e] rounded-[40px] p-8 shadow-xl max-w-6xl mx-auto">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-[300px]">

        <!-- CUADRO PARA SUBIR -->
        <div onclick="document.getElementById('modalSubir').classList.remove('hidden')"
            class="group rounded-3xl bg-white/40 border-4 border-dashed border-[#bc6a50]/40 flex flex-col items-center justify-center cursor-pointer hover:bg-white transition-all">
            <span class="text-5xl mb-2"><i class="bi bi-cloud-upload text-[#3b4d57]"></i></span>
            <p class="text-[#3b4d57] font-black uppercase text-sm">Añadir Archivo</p>
        </div>

        <!-- LISTADO DE FOTOS Y VÍDEOS -->
        @forelse($items as $item)
        <div class="group relative overflow-hidden rounded-3xl bg-gray-100 shadow-md">
            @if($item->tipo == 'foto')
            <img src="{{ asset($item->url) }}"
                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
            @else
            <video src="{{ asset($item->url) }}" class="w-full h-full object-cover" muted loop onmouseover="this.play()"
                onmouseout="this.pause()"></video>
            <div class="absolute top-4 right-4 bg-black/20 backdrop-blur-md p-2 rounded-full text-white text-xs">VÍDEO
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-full text-center py-20">
            <p class="text-[#bc6a50] text-lg text-5xl">No hay fotos ni vídeos.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- EL MODAL -->
<div id="modalSubir"
    class="fixed inset-0 bg-black/70 z-[1000] hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-[40px] max-w-sm w-full p-8 shadow-2xl relative">
        <div id="form-content">
            <h3 class="text-2xl font-black text-gray-800 uppercase text-center mb-6">Subir Recuerdo</h3>

            <label
                class="block w-full h-56 border-4 border-dashed border-gray-100 rounded-[30px] relative overflow-hidden cursor-pointer bg-gray-50">
                <input type="file" id="inputMedia" class="hidden" accept="image/*,video/*"
                    onchange="previewMedia(event)">
                <div id="placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-gray-300">
                    <span class="text-4xl"><i class="bi bi-camera text-[#3b4d57]"></i></span>
                    <p class="text-[25px] font-bold mt-2 text-[#3b4d57]">FOTO O VÍDEO</p>
                </div>
                <img id="img-prev" class="absolute inset-0 w-full h-full object-cover hidden">
                <video id="vid-prev" class="absolute inset-0 w-full h-full object-cover hidden" muted loop></video>
            </label>

            <button onclick="enviarArchivo()" id="btnSend"
                class="w-full mt-8 py-4 bg-[#bc6a50] text-white rounded-2xl font-black uppercase hover:bg-[#8e4f3c] transition-all">
                Publicar Ahora
            </button>
            <button onclick="document.getElementById('modalSubir').classList.add('hidden')"
                class="w-full mt-2 text-gray-400 font-bold text-xs uppercase">Cancelar</button>
        </div>

        <div id="success-view" class="hidden text-center py-10">
            <div class="text-6xl mb-4 animate-bounce">✅</div>
            <h3 class="text-2xl font-black text-gray-800 uppercase">¡Publicado!</h3>
            <button onclick="location.reload()"
                class="mt-8 w-full py-4 bg-[#32424D] text-white rounded-2xl font-black uppercase">Actualizar
                Álbum</button>
        </div>
    </div>
</div>

<script>
    function previewMedia(event) {
        const file = event.target.files[0];
        const img = document.getElementById('img-prev');
        const vid = document.getElementById('vid-prev');
        const place = document.getElementById('placeholder');

        if (!file) return;

        const url = URL.createObjectURL(file);
        place.classList.add('hidden');

        if (file.type.includes('video')) {
            img.classList.add('hidden');
            vid.src = url;
            vid.classList.remove('hidden');
            vid.play();
        } else {
            vid.classList.add('hidden');
            img.src = url;
            img.classList.remove('hidden');
        }
    }

    function enviarArchivo() {
        const fileInput = document.getElementById('inputMedia');
        const btn = document.getElementById('btnSend');
        if (fileInput.files.length === 0) return alert("Selecciona un archivo primero");

        btn.disabled = true;
        btn.innerText = "SUBIENDO...";

        const formData = new FormData();
        formData.append('archivo', fileInput.files[0]);
        formData.append('_token', '{{ csrf_token() }}');

        fetch("{{ route('album.subir') }}", {
            method: 'POST',
            body: formData
        })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('form-content').classList.add('hidden');
                    document.getElementById('success-view').classList.remove('hidden');
                }
            })
            .catch(() => {
                alert("Error al subir el archivo");
                btn.disabled = false;
                btn.innerText = "Publicar Ahora";
            });
    }
</script>
@endsection