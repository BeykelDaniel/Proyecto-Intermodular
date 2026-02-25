@extends('layout')

@section('title', 'Chat con ' . $amigo->name)

@section('contenido')
<div class="bg-gray-50 min-h-screen p-6 font-sans">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center gap-6 mb-8 bg-white p-6 rounded-[35px] shadow-sm border-b-8 border-indigo-500">
            <div class="relative">
                <img src="{{ $amigo->perfil_foto ? '/' . $amigo->perfil_foto : 'https://ui-avatars.com/api/?name='.urlencode($amigo->name) }}" 
                     class="w-16 h-16 rounded-2xl object-cover shadow-md">
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 border-2 border-white rounded-full"></div>
            </div>
            <div>
                <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tight line-clamp-1">Charlando con {{ $amigo->name }}</h2>
                <p class="text-gray-400 font-bold uppercase text-xs tracking-widest"><i class="bi bi-shield-check text-green-500 mr-1"></i> Chat Seguro y Privado</p>
            </div>
            <a href="{{ route('pagina.amigos') }}" class="ml-auto px-6 py-4 bg-gray-100 text-gray-600 rounded-2xl font-black uppercase text-xs hover:bg-gray-200 transition-all shadow-sm">
                <i class="bi bi-arrow-left mr-2"></i> Atrás
            </a>
        </div>

        <div class="bg-white rounded-[40px] shadow-2xl border border-gray-100 overflow-hidden flex flex-col h-[650px]">
            {{-- ÁREA DE MENSAJES --}}
            <div id="chat-box" class="flex-1 overflow-y-auto p-10 flex flex-col gap-6 custom-scrollbar bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-gray-50/30">
                @php \Carbon\Carbon::setLocale('es'); @endphp
                @forelse($mensajes as $msg)
                    <div class="flex gap-4 {{ $msg->user_id == auth()->id() ? 'flex-row-reverse' : '' }}">
                        <div class="shrink-0">
                            @if($msg->user->perfil_foto)
                                <img src="/{{ $msg->user->perfil_foto }}" class="w-12 h-12 rounded-2xl object-cover shadow-sm">
                            @else
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-2xl shadow-sm">👤</div>
                            @endif
                        </div>
                        <div class="flex flex-col {{ $msg->user_id == auth()->id() ? 'items-end' : '' }} max-w-[70%]">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">{{ $msg->user_id == auth()->id() ? 'Tú' : $msg->user->name }}</span>
                                <span class="text-[10px] font-bold text-gray-300">{{ $msg->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="p-5 rounded-[25px] w-fit shadow-sm {{ $msg->user_id == auth()->id() ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none border border-gray-100' }}">
                                <p class="text-lg font-bold leading-relaxed">{{ $msg->contenido }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-center p-10">
                        <div class="w-32 h-32 bg-indigo-50 text-indigo-200 rounded-full flex items-center justify-center mb-8">
                            <i class="bi bi-chat-heart-fill text-6xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-gray-400 uppercase mb-2">¡Dile Hola a {{ $amigo->name }}!</h3>
                        <p class="text-gray-400 font-bold italic">Escribe tu primer mensaje aquí abajo.</p>
                    </div>
                @endforelse
            </div>

            {{-- FORMULARIO --}}
            <div class="p-8 bg-white border-t-4 border-gray-50">
                <form id="chat-form" action="{{ route('chat.store', $amigo->id) }}" method="POST" class="flex gap-4 items-center">
                    @csrf
                    <input type="text" name="contenido" placeholder="Escribe un mensaje cariñoso..." required autocomplete="off"
                        class="flex-1 px-8 py-6 bg-gray-50 border-2 border-gray-100 rounded-[30px] focus:bg-white focus:border-indigo-500 focus:ring-8 focus:ring-indigo-100 outline-none transition-all font-bold text-xl placeholder:text-gray-300">
                    
                    <button type="submit" class="bg-indigo-600 text-white h-20 w-20 rounded-[30px] flex items-center justify-center shadow-xl hover:bg-indigo-700 transition-all hover:scale-105 active:scale-95 group">
                        <i class="bi bi-send-fill text-3xl group-hover:rotate-12 transition-transform"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatBox = document.getElementById('chat-box');
        let lastId = {{ $mensajes->last()->id ?? 0 }};
        const currentUserId = {{ auth()->id() }};

        const scrollToBottom = () => {
            chatBox.scrollTop = chatBox.scrollHeight;
        };
        scrollToBottom();

        // Polling
        setInterval(() => {
            fetch(`{{ route('chat.nuevos', $amigo->id) }}?last_id=${lastId}`)
                .then(r => r.json())
                .then(posts => {
                    if (posts.length > 0) {
                        posts.forEach(msg => {
                            if (msg.id <= lastId) return; // Evitar duplicados por seguridad
                            
                            const isOwn = msg.user_id == currentUserId;
                            const div = document.createElement('div');
                            div.className = `flex gap-4 ${isOwn ? 'flex-row-reverse' : ''}`;
                            
                            const avatar = msg.user.perfil_foto 
                                ? `<img src="/${msg.user.perfil_foto}" class="w-12 h-12 rounded-2xl object-cover shadow-sm">`
                                : `<div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-2xl shadow-sm">👤</div>`;

                            div.innerHTML = `
                                <div class="shrink-0">${avatar}</div>
                                <div class="flex flex-col ${isOwn ? 'items-end' : ''} max-w-[70%]">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">${isOwn ? 'Tú' : msg.user.name}</span>
                                        <span class="text-[10px] font-bold text-gray-300">Ahora mismo</span>
                                    </div>
                                    <div class="p-5 rounded-[25px] w-fit shadow-sm ${isOwn ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none border border-gray-100'}">
                                        <p class="text-lg font-bold leading-relaxed">${msg.contenido}</p>
                                    </div>
                                </div>
                            `;
                            chatBox.appendChild(div);
                            lastId = Math.max(lastId, msg.id);
                        });
                        scrollToBottom();
                    }
                });
        }, 3000);

        // Envío AJAX
        const form = document.getElementById('chat-form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const input = this.querySelector('input[name="contenido"]');
            if(!input.value.trim()) return;

            const data = new FormData(this);
            const btn = this.querySelector('button');
            
            btn.disabled = true;
            fetch(this.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: data
            }).then(() => {
                input.value = '';
                btn.disabled = false;
                // No esperamos al polling para mejor UX
            });
        });
    });
</script>
@endpush
@endsection
