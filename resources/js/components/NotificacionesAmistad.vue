<template>
    <li class="relative dropdown-container">
        <button @click="toggle" class="relative p-2 text-[#32424D] hover:text-[#C2841D] transition-colors">
            <i class="bi bi-bell-fill text-2xl"></i>
            <span v-if="count > 0" class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-full border-2 border-[#E8D258]">
                {{ count }}
            </span>
        </button>

        <div v-if="isOpen" @click.away="isOpen = false" 
             class="dropdown-content absolute z-[60] mt-6 bg-white rounded-[30px] shadow-2xl p-6 border border-gray-100 right-0 lg:left-1/2 lg:-translate-x-1/2 min-w-[300px]">
            <p class="text-[11px] font-black text-gray-400 uppercase text-center mb-4 tracking-widest">Solicitudes de Amistad</p>
            <ul class="space-y-4 max-h-[300px] overflow-y-auto">
                <li v-for="sol in solicitudes" :key="sol.id" 
                    class="flex items-center justify-between gap-3 p-3 bg-gray-50 rounded-2xl border-2 border-gray-100">
                    <div class="flex items-center gap-3">
                        <img :src="sol.perfil_foto ? '/' + sol.perfil_foto : 'https://ui-avatars.com/api/?name=' + sol.name" 
                             class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
                        <span class="text-sm font-bold text-gray-700">{{ sol.name }}</span>
                    </div>
                    <div class="flex gap-2">
                        <a :href="'/perfil/' + sol.id" class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center hover:bg-indigo-200 transition-colors" title="Ver Perfil">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        <button @click="aceptar(sol.id)" class="w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center hover:bg-green-200 transition-colors" title="Aceptar">
                            <i class="bi bi-check-lg"></i>
                        </button>
                        <button @click="rechazar(sol.id)" class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center hover:bg-red-200 transition-colors" title="Rechazar">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </li>
                <li v-if="count === 0" class="text-center py-4 text-gray-400 italic text-sm">No tienes solicitudes pendientes</li>
            </ul>
        </div>
    </li>
</template>

<script>
export default {
    props: ['routeIndex', 'routeAceptar', 'routeRechazar', 'csrf'],
    data() {
        return {
            isOpen: false,
            count: 0,
            solicitudes: [],
            interval: null
        }
    },
    mounted() {
        this.poll();
        this.interval = setInterval(this.poll, 7000);
    },
    beforeUnmount() {
        clearInterval(this.interval);
    },
    methods: {
        toggle() {
            this.isOpen = !this.isOpen;
        },
        poll() {
            fetch(this.routeIndex)
                .then(r => r.json())
                .then(data => {
                    this.count = data.count;
                    this.solicitudes = data.solicitudes;
                });
        },
        aceptar(id) {
            fetch(this.routeAceptar.replace(':id', id), { 
                method: 'POST', 
                headers: { 'X-CSRF-TOKEN': this.csrf } 
            }).then(() => { 
                this.poll(); 
                if (window.Swal) window.Swal.fire('¡Amistad aceptada!', '', 'success'); 
            });
        },
        rechazar(id) {
            fetch(this.routeRechazar.replace(':id', id), { 
                method: 'POST', 
                headers: { 'X-CSRF-TOKEN': this.csrf } 
            }).then(() => { 
                this.poll(); 
            });
        }
    }
}
</script>
