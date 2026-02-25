@extends('layout')

@section('title', 'Álbum: ' . $actividad->nombre)

@section('contenido')
<div class="bg-gray-50 min-h-screen p-6 font-sans">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center gap-4 mb-8 bg-white p-6 rounded-3xl shadow-sm">
            @if($actividad->imagen)
                <img src="{{ asset($actividad->imagen) }}" class="w-16 h-16 rounded-2xl object-cover shadow-sm">
            @endif
            <div>
                <h2 class="text-3xl font-black text-gray-800 uppercase">{{ $actividad->nombre }}</h2>
                <p class="text-gray-400 font-bold uppercase text-xs tracking-widest"><i class="bi bi-images text-[#bc6a50] mr-1"></i> Álbum de la Actividad</p>
            </div>
            <a href="{{ route('pagina.album') }}" class="ml-auto px-6 py-3 bg-gray-100 text-gray-600 rounded-2xl font-black uppercase text-xs hover:bg-gray-200 transition-all shadow-sm">Volver</a>
        </div>

        {{-- SUB NAVBAR SENIOR --}}
        <div class="flex justify-center mb-10">
            <nav class="flex gap-4 bg-white p-2 rounded-[30px] shadow-sm border border-gray-100">
                <a href="{{ route('actividades.foro', $actividad->id) }}" 
                    class="flex items-center gap-4 px-10 py-5 rounded-[25px] text-lg font-black uppercase tracking-widest transition-all {{ request()->routeIs('actividades.foro') ? 'bg-indigo-600 text-white shadow-xl' : 'text-gray-400 hover:bg-gray-50' }}">
                    <i class="bi bi-chat-dots-fill text-2xl"></i> Foro
                </a>
                <a href="{{ route('actividades.album', $actividad->id) }}" 
                    class="flex items-center gap-4 px-10 py-5 rounded-[25px] text-lg font-black uppercase tracking-widest transition-all {{ request()->routeIs('actividades.album') ? 'bg-pink-500 text-white shadow-xl' : 'text-gray-400 hover:bg-gray-50' }}">
                    <i class="bi bi-images text-2xl"></i> Álbum
                </a>
            </nav>
        </div>

        {{-- SECCIÓN DE SUBIDA --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 mb-8">
            <h4 class="text-lg font-black text-gray-800 uppercase mb-4">Compartir fotos/videos</h4>
            <div id="dropzone" class="border-4 border-dashed border-gray-100 rounded-[30px] p-10 flex flex-col items-center justify-center cursor-pointer hover:border-[#bc6a50]/30 hover:bg-gray-50 transition-all group relative">
                <input type="file" id="fileInput" class="absolute inset-0 opacity-0 cursor-pointer">
                <div class="w-16 h-16 bg-gray-50 group-hover:bg-white rounded-2xl flex items-center justify-center mb-4 transition-colors">
                    <i class="bi bi-cloud-upload-fill text-3xl text-gray-300 group-hover:text-[#bc6a50]"></i>
                </div>
                <p class="text-gray-400 font-bold uppercase text-sm group-hover:text-gray-600">Haz clic o arrastra archivos aquí</p>
                <p class="text-gray-400 text-xs mt-1">Imágenes o Vídeos (Máx. 50MB)</p>
                
                {{-- Barra de Progreso --}}
                <div id="progressContainer" class="hidden w-full max-w-xs bg-gray-100 rounded-full h-2 mt-6 overflow-hidden">
                    <div id="progressBar" class="bg-[#bc6a50] h-full w-0 transition-all duration-300"></div>
                </div>
            </div>
        </div>

        {{-- GALERÍA --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($items as $index => $item)
                <div class="aspect-square relative group rounded-3xl overflow-hidden shadow-sm border border-gray-100 bg-white">
                    @if($item->tipo == 'foto')
                        <img src="{{ asset($item->url) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <video src="{{ asset($item->url) }}" class="w-full h-full object-cover"></video>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="bi bi-play-circle-fill text-white/80 text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-4">
                        <div class="flex gap-4">
                            <button onclick="verMedia({{ $index }})" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-800 hover:scale-110 transition-transform shadow-xl" title="Ver grande">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                            
                            @if($item->user_id == Auth::id() || Auth::user()->email == 'cabrerajosedaniel89@gmail.com')
                                <button onclick="eliminarMedia({{ $item->id }})" class="w-12 h-12 bg-red-500 rounded-2xl flex items-center justify-center text-white hover:scale-110 transition-transform shadow-xl" title="Borrar">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-20 rounded-3xl border border-gray-100 text-center">
                    <i class="bi bi-images text-5xl text-gray-100 mb-4 block"></i>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">Aún no hay fotos en este álbum.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- MODAL VISTA PREVIA CON GALERÍA --}}
<div id="mediaModal" class="fixed inset-0 bg-black/95 z-[9999] hidden flex flex-col items-center justify-center p-4 backdrop-blur-md">
    <button class="absolute top-6 right-6 text-white/50 hover:text-white hover:rotate-90 transition-all text-5xl z-[10000]" onclick="cerrarMedia()">
        <i class="bi bi-x"></i>
    </button>
    
    {{-- Navegación Lateral --}}
    <button onclick="cambiarMedia(-1)" id="btnPrev" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/30 hover:text-white transition-all text-6xl z-[10000]">
        <i class="bi bi-chevron-compact-left"></i>
    </button>
    <button onclick="cambiarMedia(1)" id="btnNext" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/30 hover:text-white transition-all text-6xl z-[10000]">
        <i class="bi bi-chevron-compact-right"></i>
    </button>

    <div id="mediaContent" class="w-full h-full flex items-center justify-center p-8 select-none" onclick="cerrarMedia()">
        {{-- Aquí se inyecta la imagen/video --}}
    </div>
    
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 bg-white/10 backdrop-blur-md px-6 py-2 rounded-full text-white/70 font-bold text-sm">
        <span id="currentIndexText">0</span> / <span id="totalItemsText">0</span>
    </div>
</div>

<form id="deleteMediaForm" action="" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    const mediaItems = @json($items);
    let currentIndex = 0;

    const fileInput = document.getElementById('fileInput');
    const progressBar = document.getElementById('progressBar');
    const progressContainer = document.getElementById('progressContainer');

    fileInput.onchange = function() {
        if (!this.files[0]) return;
        
        const formData = new FormData();
        formData.append('archivo', this.files[0]);
        formData.append('actividad_id', '{{ $actividad->id }}');

        progressContainer.classList.remove('hidden');
        
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('album.subir') }}', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        xhr.upload.onprogress = (e) => {
            if (e.lengthComputable) {
                const percent = (e.loaded / e.total) * 100;
                progressBar.style.width = percent + '%';
            }
        };

        xhr.onload = function() {
            if (xhr.status === 200) {
                location.reload();
            } else {
                alert('Error al subir el archivo. Inténtalo de nuevo.');
                progressContainer.classList.add('hidden');
                progressBar.style.width = '0%';
            }
        };

        xhr.send(formData);
    };

    function verMedia(index) {
        currentIndex = index;
        const item = mediaItems[currentIndex];
        const content = document.getElementById('mediaContent');
        
        if (item.tipo === 'foto') {
            content.innerHTML = `<img src="/${item.url}" class="max-w-full max-h-full rounded-2xl shadow-2xl object-contain animate-fadeIn" onclick="event.stopPropagation()">`;
        } else {
            content.innerHTML = `<video src="/${item.url}" controls autoplay class="max-w-full max-h-full rounded-2xl shadow-2xl animate-fadeIn" onclick="event.stopPropagation()"></video>`;
        }
        
        document.getElementById('currentIndexText').innerText = currentIndex + 1;
        document.getElementById('totalItemsText').innerText = mediaItems.length;
        
        document.getElementById('mediaModal').classList.remove('hidden');
        
        // Atajos de teclado
        document.addEventListener('keydown', handleKeyPress);
    }

    function cambiarMedia(dir) {
        let nextIndex = currentIndex + dir;
        if (nextIndex < 0) nextIndex = mediaItems.length - 1;
        if (nextIndex >= mediaItems.length) nextIndex = 0;
        verMedia(nextIndex);
    }

    function handleKeyPress(e) {
        if (e.key === 'ArrowLeft') cambiarMedia(-1);
        if (e.key === 'ArrowRight') cambiarMedia(1);
        if (e.key === 'Escape') cerrarMedia();
    }

    function cerrarMedia() {
        document.getElementById('mediaModal').classList.add('hidden');
        document.getElementById('mediaContent').innerHTML = '';
        document.removeEventListener('keydown', handleKeyPress);
    }

    function eliminarMedia(id) {
        Swal.fire({
            title: '¿Quieres borrar esta foto?',
            text: "No podrás recuperarla.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, borrar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteMediaForm');
                form.action = `/album/${id}`;
                form.submit();
            }
        })
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>
@endsection
@endsection
