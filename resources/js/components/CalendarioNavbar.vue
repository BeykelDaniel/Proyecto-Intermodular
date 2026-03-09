<template>
    <li class="relative dropdown-container">
        <button @click.stop="toggle"
            class="text-[#32424D] uppercase flex items-center whitespace-nowrap text-xs md:text-base hover:text-[#C2841D] transition-colors focus:outline-none">
            <span class="font-black">Mis Actividades</span>
            <svg class="w-4 h-4 ms-2 transition-transform duration-300" :class="{'rotate-180': isOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div v-if="isOpen" v-click-outside="() => isOpen = false" @click.stop
            class="dropdown-content absolute z-[9999] mt-6 bg-white rounded-[40px] shadow-2xl p-6 border-2 border-[#32424D]/10 left-1/2 -translate-x-1/2 min-w-[320px] md:min-w-[360px]">
            
            <!-- Calendario Primero -->
            <div class="mb-2">
                <div class="bg-indigo-50/30 rounded-[30px] p-2 border border-indigo-100/50">
                    <div ref="calendarEl" class="calendar-mini"></div>
                </div>
            </div>

            <!-- Lista Después -->
            <div class="border-t border-gray-100 pt-4">
                <p class="text-[11px] font-black text-gray-400 uppercase text-center mb-4 tracking-tighter">Tus próximas citas</p>
                <ul class="space-y-3 max-h-[180px] overflow-y-auto pr-2 custom-scrollbar">
                    <li v-for="act in inscripciones" :key="act.fecha + act.nombre" 
                        class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50 border-l-[4px] shadow-sm transform hover:scale-[1.02] transition-all"
                        :style="{ borderLeftColor: act.color }">
                        <div class="flex-1">
                            <p class="text-[#32424D] font-black text-sm uppercase leading-none mb-1">{{ act.nombre }}</p>
                            <p class="text-[10px] text-gray-500 font-bold italic">{{ act.fechaFormateada }}</p>
                        </div>
                    </li>
                    <li v-if="inscripciones.length === 0" class="text-sm text-gray-400 font-bold italic text-center py-4 bg-gray-50 rounded-2xl">
                        Aún no tienes planes
                    </li>
                </ul>
            </div>
        </div>
    </li>
</template>

<script>
import flatpickr from 'flatpickr';
import { Spanish } from 'flatpickr/dist/l10n/es.js';

export default {
    props: ['initialInscripciones', 'routeInscritas', 'isAuth'],
    directives: {
        'click-outside': {
            mounted(el, binding) {
                el.clickOutsideEvent = (event) => {
                    if (!(el === event.target || el.contains(event.target))) {
                        binding.value();
                    }
                };
                document.addEventListener("click", el.clickOutsideEvent);
            },
            unmounted(el) {
                document.removeEventListener("click", el.clickOutsideEvent);
            },
        },
    },
    data() {
        let items = [];
        try {
            items = typeof this.initialInscripciones === 'string' 
                ? JSON.parse(this.initialInscripciones) 
                : (this.initialInscripciones || []);
        } catch (e) {
            console.error("Error parsing initialInscripciones:", e);
        }

        return {
            isOpen: false,
            inscripciones: items,
            fp: null,
            interval: null
        }
    },
    methods: {
        toggle() {
            this.isOpen = !this.isOpen;
            console.log("Calendario toggle:", this.isOpen);
            if (this.isOpen) {
                this.$nextTick(() => {
                    this.initCalendar();
                });
            }
        },
        initCalendar() {
            if (!this.$refs.calendarEl) return;

            // Destruir instancia previa si existe (v-if recrea el DOM)
            if (this.fp) {
                this.fp.destroy();
                this.fp = null;
            }

            try {
                this.fp = flatpickr(this.$refs.calendarEl, {
                    inline: true,
                    locale: Spanish,
                    onDayCreate: (dObj, dStr, fp, dayElem) => {
                        const f = dayElem.dateObj.toLocaleDateString('en-CA');
                        const act = this.inscripciones.find(a => a.fecha === f);
                        if (act) {
                            dayElem.classList.add("dia-resaltado");
                            dayElem.style.setProperty('--color-actividad', act.color);
                        }
                    }
                });
            } catch (e) {
                console.error("Flatpickr Error:", e);
            }
        },
        poll() {
            if (!this.isAuth) return;
            fetch(this.routeInscritas)
                .then(r => r.json())
                .then(data => {
                    if (data && JSON.stringify(data) !== JSON.stringify(this.inscripciones)) {
                        console.log("Nuevas inscripciones detectadas:", data.length);
                        this.inscripciones = data;
                        if (this.fp) this.fp.redraw();
                    }
                })
                .catch(err => console.error("Error polling inscripciones:", err));
        }
    },
    mounted() {
        console.log("CalendarioNavbar montado. Inscripciones iniciales:", this.inscripciones.length);
        if (this.isAuth) {
            this.interval = setInterval(this.poll, 10000);
            window.addEventListener('inscripcion-actualizada', this.poll);
        }
    },
    beforeUnmount() {
        if (this.interval) clearInterval(this.interval);
        window.removeEventListener('inscripcion-actualizada', this.poll);
        if (this.fp) this.fp.destroy();
    }
}
</script>
