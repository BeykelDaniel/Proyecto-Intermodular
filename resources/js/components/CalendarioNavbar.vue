<template>
    <li class="relative dropdown-container">
        <button @click="toggle"
            class="text-[#32424D] uppercase flex items-center whitespace-nowrap text-xs md:text-base hover:text-[#C2841D] transition-colors">
            Mis Actividades
            <svg class="w-4 h-4 ms-2" :class="{'rotate-180': isOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div v-if="isOpen" @click.away="isOpen = false"
            class="dropdown-content absolute z-50 mt-6 bg-white rounded-[30px] shadow-2xl p-6 border border-gray-100 left-1/2 -translate-x-1/2 min-w-[320px] md:min-w-[350px]">
            <div ref="calendarEl"></div>
            <div class="mt-4 border-t-2 pt-4">
                <p class="text-[11px] font-black text-gray-400 uppercase text-center mb-3">Tus próximas citas</p>
                <ul class="space-y-3 max-h-[200px] overflow-y-auto">
                    <li v-for="act in inscripciones" :key="act.fecha + act.nombre" 
                        class="flex items-center gap-3 p-2 rounded-xl bg-gray-50 border-l-4 shadow-sm"
                        :style="{ borderLeftColor: act.color }">
                        <div class="flex-1">
                            <p class="text-[#32424D] font-bold text-sm leading-tight">{{ act.nombre }}</p>
                            <p class="text-[10px] text-gray-500 italic">{{ act.fechaFormateada }}</p>
                        </div>
                    </li>
                    <li v-if="inscripciones.length === 0" class="text-sm text-gray-400 italic text-center">Aún no tienes planes</li>
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
    data() {
        return {
            isOpen: false,
            inscripciones: JSON.parse(this.initialInscripciones || '[]'),
            fp: null,
            interval: null
        }
    },
    methods: {
        toggle() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.$nextTick(() => {
                    this.initCalendar();
                });
            }
        },
        initCalendar() {
            if (this.fp) {
                this.fp.redraw();
                return;
            }
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
        },
        poll() {
            if (!this.isAuth) return;
            fetch(this.routeInscritas)
                .then(r => r.json())
                .then(data => {
                    if (data && data.length !== this.inscripciones.length) {
                        this.inscripciones = data;
                        if (this.fp) this.fp.redraw();
                    }
                });
        }
    },
    mounted() {
        if (this.isAuth) {
            this.interval = setInterval(this.poll, 10000);
        }
    },
    beforeUnmount() {
        if (this.interval) clearInterval(this.interval);
        if (this.fp) this.fp.destroy();
    }
}
</script>
