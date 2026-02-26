@extends('layout')

@section('title', 'Álbum: ' . $actividad->nombre)

@section('contenido')
<div class="bg-gray-50 min-h-screen p-6 font-sans">
    <div class="max-w-4xl mx-auto">

        {{-- MODAL DE MENSAJES --}}
        <div id="messageModal" class="fixed inset-0 bg-black/80 z-[10007] hidden flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl transform animate-fadeIn relative">
                <i id="imgMensaje" class="bi text-5xl mb-4 block"></i>
                <h3 id="tituloMensaje" class="text-2xl font-black text-gray-800 uppercase mb-2"></h3>
                <p id="textoMensaje" class="text-gray-500 font-bold text-lg mb-6 uppercase"></p>
                <button onclick="cerrarMensaje()" class="w-full py-3 bg-gray-100 text-gray-600 rounded-2xl font-black uppercase text-lg hover:bg-gray-200 transition-all shadow-sm">Aceptar</button>
            </div>
        </div>

        {{-- CABECERA --}}
        <div class="flex items-center gap-4 mb-8 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            @if($actividad->imagen)
                <img src="{{ asset($actividad->imagen) }}" class="w-16 h-16 rounded-2xl object-cover shadow-sm">
            @endif
            <div>
                <h2 class="text-3xl font-black text-gray-800 uppercase">{{ $actividad->nombre }}</h2>
                <p class="text-gray-400 font-bold uppercase text-xs tracking-widest"><i class="bi bi-images text-pink-500 mr-1"></i> Álbum Digital</p>
            </div>
            <a href="{{ route('pagina.album') }}" class="ml-auto px-6 py-3 bg-gray-100 text-gray-600 rounded-2xl font-black uppercase text-xs hover:bg-gray-200 transition-all">Volver</a>
        </div>

        {{-- DROPZONE --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 mb-8">
            <h4 class="text-lg font-black text-gray-800 uppercase mb-4 text-center">Subir contenido</h4>
            <div id="dropzone" class="border-4 border-dashed border-gray-100 rounded-[30px] p-10 flex flex-col items-center justify-center cursor-pointer hover:border-pink-300 hover:bg-pink-50 transition-all group relative">
                <input type="file" id="fileInput" class="absolute inset-0 opacity-0 cursor-pointer z-50" accept="image/*,video/*">
                <div class="w-20 h-20 bg-gray-50 group-hover:bg-white rounded-2xl flex items-center justify-center mb-4 transition-colors">
                    <i class="bi bi-cloud-arrow-up-fill text-4xl text-gray-300 group-hover:text-pink-500"></i>
                </div>
                <p class="text-gray-400 font-bold uppercase text-sm group-hover:text-gray-600 text-center">Pulsa aquí para elegir fotos o videos</p>
                
                <div id="progressContainer" class="hidden w-full max-w-md bg-gray-100 rounded-full h-4 mt-8 overflow-hidden">
                    <div id="progressBar" class="bg-pink-500 h-full w-0 transition-all duration-300 flex items-center justify-center text-[14px] text-white font-bold">0%</div>
                </div>
            </div>
        </div>

        {{-- GALERÍA --}}
        <div id="galeria-grid" class="grid grid-cols-2 md:grid-cols-3 gap-6">
            {{-- Se rellena dinámicamente por JS --}}
        </div>
    </div>
</div>

<!-- MODAL LIGHTBOX -->
<div id="mediaModal" class="fixed inset-0 bg-black/95 z-[9999] hidden flex flex-col items-center justify-center p-4 backdrop-blur-md">

     <!-- BOTÓN CERRAR -->
    <button onclick="cerrarMedia()" class="absolute top-6 right-6 w-14 h-14 rounded-full border-2 border-white bg-black/40 shadow-2xl flex items-center justify-center text-white text-2xl hover:bg-black/60 transition-all duration-300 z-[10002]">
        <i class="bi bi-x-lg"></i>
    </button>

    <!-- FLECHA IZQUIERDA -->
    <button onclick="cambiarMedia(-1)" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 w-16 h-16 rounded-full border-2 border-white bg-black/40 shadow-2xl flex items-center justify-center text-white text-2xl hover:bg-black/60 transition-all duration-300 z-[10001]">
        <i class="bi bi-chevron-left"></i>
    </button>

    <!-- CONTENIDO -->
    <div id="mediaContent" class="w-full h-full flex items-center justify-center" onclick="cerrarMedia()"></div>

    <!-- FLECHA DERECHA -->
    <button onclick="cambiarMedia(1)" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 w-16 h-16 rounded-full border-2 border-white bg-black/40 shadow-2xl flex items-center justify-center text-white text-2xl hover:bg-black/60 transition-all duration-300 z-[10001]">
        <i class="bi bi-chevron-right"></i>
    </button>

    <!-- CONTADOR FIJO ABAJO -->
    <div id="mediaCounter" class="mt-4 text-white text-xl font-bold uppercase tracking-widest z-[10003]"></div>
</div>

{{-- MODAL DE CONFIRMACIÓN --}}
<div id="confirmModal" class="fixed inset-0 bg-black/80 z-[10006] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl transform animate-fadeIn">
        <i class="bi bi-exclamation-octagon text-red-500 text-5xl mb-4"></i>
        <h3 class="text-2xl font-black text-gray-800 uppercase mb-2">¿Estás seguro?</h3>
        <p class="text-gray-500 font-bold text-lg mb-6 uppercase">Esta acción no se puede deshacer.</p>
        <div class="flex gap-3">
            <button onclick="cerrarConfirmar()" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-2xl font-black uppercase text-lg">Cancelar</button>
            <button id="btnConfirmarEliminar" class="flex-1 py-3 bg-red-500 text-white rounded-2xl font-black uppercase text-lg shadow-lg shadow-red-200">Eliminar</button>
        </div>
    </div>
</div>

<script>
let mediaItems = @json($items); // Archivos cargados desde el backend
let currentIndex = 0;
let itemAEliminar = null;
const authUserId = {{ Auth::id() }};
const adminEmail = 'cabrerajosedaniel89@gmail.com';
const userEmail = '{{ Auth::user()->email }}';

/* --- MENSAJES MODAL --- */
function showToast(mensaje, tipo='success') {
    const modal = document.getElementById('messageModal');
    const icon = document.getElementById('imgMensaje');
    const title = document.getElementById('tituloMensaje');
    
    if (tipo === 'success') {
        icon.className = 'bi bi-check-circle-fill text-green-500 text-6xl mb-4 block animate-bounce';
        title.innerText = '¡Éxito!';
    } else {
        icon.className = 'bi bi-exclamation-triangle-fill text-red-500 text-6xl mb-4 block animate-pulse';
        title.innerText = 'Error';
    }
    
    document.getElementById('textoMensaje').innerText = mensaje;
    modal.classList.remove('hidden');
}

function cerrarMensaje() {
    document.getElementById('messageModal').classList.add('hidden');
}

/* --- GALERÍA --- */
function renderizarGaleria(){
    const grid = document.getElementById('galeria-grid'); 
    grid.innerHTML = '';
    const baseUrl = '{{ asset("") }}';
    mediaItems.forEach((item,index)=>{
        const esDuenio = (item.user_id==authUserId || userEmail==adminEmail);
        const mediaHtml = item.tipo==='foto'
            ? `<img src="${baseUrl}${item.url}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">`
            : `<video src="${baseUrl}${item.url}" class="w-full h-full object-cover"></video>
               <div class="absolute inset-0 flex items-center justify-center">
                   <i class="bi bi-play-circle-fill text-white/80 text-5xl"></i>
               </div>`;

        const div = document.createElement('div');
        div.className="aspect-square relative group rounded-3xl overflow-hidden shadow-sm border border-gray-100 bg-white animate-fadeIn";
        div.innerHTML=`
            ${mediaHtml}
            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-4">
                <button onclick="verMedia(${index})" class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-gray-800 hover:scale-110 transition-transform text-2xl">
                    <i class="bi bi-eye-fill"></i>
                </button>
                ${esDuenio?`<button onclick="confirmarEliminar(${item.id})" class="w-16 h-16 bg-red-500 rounded-2xl flex items-center justify-center text-white hover:scale-110 transition-transform text-2xl">
                    <i class="bi bi-trash-fill"></i>
                </button>`:''}
            </div>`;
        grid.appendChild(div);
    });
}

/* --- MODAL --- */
function verMedia(index){
    if(index < 0) index = mediaItems.length - 1;
    if(index >= mediaItems.length) index = 0;
    currentIndex = index;
    const item = mediaItems[currentIndex];
    const baseUrl = '{{ asset("") }}';
    const url = `${baseUrl}${item.url}`;
    const mediaContent = document.getElementById('mediaContent');
    mediaContent.innerHTML = item.tipo==='foto'
        ? `<img src="${url}" class="max-w-full max-h-full rounded-2xl shadow-2xl object-contain animate-fadeIn" onclick="event.stopPropagation()">`
        : `<video src="${url}" controls autoplay class="max-w-full max-h-full rounded-2xl shadow-2xl animate-fadeIn" onclick="event.stopPropagation()"></video>`;
    document.getElementById('mediaCounter').innerText = `${currentIndex+1} / ${mediaItems.length}`;
    document.getElementById('mediaModal').classList.remove('hidden');
}

function cambiarMedia(dir){ verMedia(currentIndex + dir); }
function cerrarMedia(){ document.getElementById('mediaModal').classList.add('hidden'); }

/* --- ELIMINAR --- */
function confirmarEliminar(id){
    itemAEliminar = id;
    document.getElementById('confirmModal').classList.remove('hidden');
}
function cerrarConfirmar(){
    document.getElementById('confirmModal').classList.add('hidden');
    itemAEliminar = null;
}

document.getElementById('btnConfirmarEliminar').onclick = function(){
    if(!itemAEliminar) return;
    const id = itemAEliminar;
    cerrarConfirmar();
    
    const eliminarUrl = `{{ url('album') }}/${id}`;
    
    // Usamos POST con _method=DELETE (Spoofing) para evitar bloqueos de métodos HTTP en XAMPP/Apache
    const formData = new FormData();
    formData.append('_method', 'DELETE');

    fetch(eliminarUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async res => {
        if(!res.ok) {
            const text = await res.text();
            console.error("Respuesta fallida del servidor:", text);
            throw new Error(`Error HTTP: ${res.status}`);
        }
        return res.json();
    })
    .then(data => {
        if(data.success){
            mediaItems = mediaItems.filter(item => item.id !== id);
            renderizarGaleria();
            showToast("Archivo eliminado correctamente");
            // Ajustar el modal si estaba abierto
            if(currentIndex >= mediaItems.length) currentIndex = mediaItems.length - 1;
            if(mediaItems.length > 0) verMedia(currentIndex);
            else cerrarMedia();
        } else {
            showToast(data.message || "Error al eliminar", "error");
        }
    })
    .catch(err => {
        console.error("Error en fetch:", err);
        showToast("Error de red o del servidor. Revisa F12.", "error");
    });
}

/* --- SUBIDA DE ARCHIVOS --- */
document.addEventListener('DOMContentLoaded', function(){
    renderizarGaleria();
    const fileInput = document.getElementById('fileInput');
    fileInput?.addEventListener('change', function(e){
        const file = e.target.files[0]; if(!file) return;
        const formData = new FormData();
        formData.append('archivo', file);
        formData.append('actividad_id', '{{ $actividad->id }}');

        document.getElementById('progressContainer').classList.remove('hidden');

        const xhr = new XMLHttpRequest();
        xhr.open('POST','{{ route("album.subir") }}',true);
        xhr.setRequestHeader('X-CSRF-TOKEN','{{ csrf_token() }}');

        xhr.upload.onprogress = (ev)=>{
            const percent = Math.round((ev.loaded/ev.total)*100);
            document.getElementById('progressBar').style.width = percent+'%';
            document.getElementById('progressBar').innerText = percent+'%';
        };

        xhr.onload = function(){
            if(xhr.status===200){
                const res=JSON.parse(xhr.responseText);
                mediaItems.unshift(res.item);
                renderizarGaleria();
                showToast("¡Contenido subido con éxito!");
                document.getElementById('progressContainer').classList.add('hidden');
                document.getElementById('progressBar').style.width='0%';
                fileInput.value='';
            }else{
                showToast("Error al subir el archivo","error");
                document.getElementById('progressContainer').classList.add('hidden');
            }
        };
        xhr.send(formData);
    });
});
</script>

<style>
    @keyframes fadeIn{from{opacity:0;transform:scale(0.9);}to{opacity:1;transform:scale(1);}}
    .animate-fadeIn{animation:fadeIn 0.3s ease-out forwards;}
</style>
@endsection