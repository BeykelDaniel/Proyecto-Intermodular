<template>
    <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden border border-gray-100 flex flex-col h-[600px]">
        <!-- Chat Box -->
        <div ref="chatBox" class="flex-1 overflow-y-auto p-6 md:p-10 space-y-8 bg-[#f8fafc]/50 custom-scrollbar">
            <div v-for="msg in mensajesList" :key="msg.id" 
                 :class="['flex gap-4', msg.user_id == currentUserId ? 'flex-row-reverse' : '']">
                
                <div class="shrink-0">
                    <img v-if="msg.user.perfil_foto" :src="'/' + msg.user.perfil_foto" 
                         class="w-12 h-12 rounded-2xl object-cover shadow-sm">
                    <div v-else class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-2xl shadow-sm">👤</div>
                </div>

                <div :class="['flex flex-col', msg.user_id == currentUserId ? 'items-end' : '', 'max-w-[75%]']">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">
                            {{ msg.user_id == currentUserId ? 'Tú' : msg.user.name }}
                        </span>
                        <span class="text-[10px] font-bold text-gray-300">
                            {{ formatTime(msg.created_at) }}
                        </span>
                    </div>
                    <div :class="['p-5 rounded-[25px] w-fit shadow-sm', 
                                msg.user_id == currentUserId ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none border border-gray-100']">
                        <p class="text-lg font-bold leading-relaxed">{{ msg.contenido }}</p>
                    </div>
                </div>
            </div>
            <div v-if="mensajesList.length === 0" class="h-full flex flex-col items-center justify-center text-gray-300">
                <i class="bi bi-chat-heart text-6xl mb-4 opacity-20"></i>
                <p class="font-bold uppercase tracking-widest text-sm">Dile algo amable a {{ amigoName }}</p>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-6 bg-white border-t border-gray-100">
            <form @submit.prevent="enviar" class="relative flex items-center gap-3">
                <input v-model="nuevoMensaje" type="text" placeholder="Escribe un mensaje..."
                       class="w-full bg-gray-50 border-2 border-gray-100 rounded-[25px] px-8 py-5 text-lg font-bold focus:border-indigo-600 focus:ring-0 transition-all"
                       :disabled="enviando">
                <button type="submit" :disabled="enviando || !nuevoMensaje.trim()"
                        class="bg-indigo-600 text-white w-16 h-16 rounded-full flex items-center justify-center shadow-lg hover:bg-indigo-700 hover:scale-110 active:scale-95 transition-all shrink-0">
                    <i v-if="!enviando" class="bi bi-send-fill text-2xl"></i>
                    <div v-else class="w-6 h-6 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
                </button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: ['initialMensajes', 'amigoId', 'amigoName', 'currentUserId', 'routeStore', 'routeNuevos', 'csrf'],
    data() {
        return {
            mensajesList: JSON.parse(this.initialMensajes || '[]'),
            nuevoMensaje: '',
            enviando: false,
            lastId: 0,
            interval: null
        }
    },
    methods: {
        formatTime(dateStr) {
            if (!dateStr) return 'Ahora mismo';
            const date = new Date(dateStr);
            const now = new Date();
            const diff = (now - date) / 1000;
            if (diff < 60) return 'Hace un momento';
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        },
        scrollToBottom() {
            this.$nextTick(() => {
                const chatBox = this.$refs.chatBox;
                if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
            });
        },
        enviar() {
            if (!this.nuevoMensaje.trim() || this.enviando) return;
            this.enviando = true;
            
            const content = this.nuevoMensaje;
            this.nuevoMensaje = '';

            fetch(this.routeStore, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': this.csrf, 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ contenido: content })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    this.poll();
                }
            })
            .finally(() => {
                this.enviando = false;
            });
        },
        poll() {
            fetch(`${this.routeNuevos}?last_id=${this.lastId}`)
                .then(r => r.json())
                .then(posts => {
                    if (posts.length > 0) {
                        const newOnes = posts.filter(m => !this.mensajesList.some(em => em.id === m.id));
                        if (newOnes.length > 0) {
                            this.mensajesList = [...this.mensajesList, ...newOnes];
                            this.lastId = Math.max(...this.mensajesList.map(m => m.id));
                            this.scrollToBottom();
                        }
                    }
                });
        }
    },
    mounted() {
        if (this.mensajesList.length > 0) {
            this.lastId = Math.max(...this.mensajesList.map(m => m.id));
        }
        this.scrollToBottom();
        this.interval = setInterval(this.poll, 3000);
    },
    beforeUnmount() {
        clearInterval(this.interval);
    }
}
</script>
