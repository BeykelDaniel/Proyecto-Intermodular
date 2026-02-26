<template>
  <div class="relative bg-[#E8D258] rounded-[40px] overflow-hidden border-4 border-[#32424D] shadow-2xl h-[600px] md:h-[700px]">
    
    <div v-for="(slide, index) in slides" :key="index">
      <transition 
        enter-active-class="transition ease-out duration-700"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition ease-in duration-300"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div v-if="activeSlide === index" class="absolute inset-0">
          
          <img 
            :src="slide.image" 
            class="w-full h-full object-cover block opacity-30" 
            loading="eager"
            @error="handleError"
          >
          
          <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-20">
            <h1 class="text-5xl md:text-7xl font-black text-[#32424D] mb-6 leading-tight" v-html="slide.title"></h1>
            <p class="text-2xl text-[#32424D] font-bold max-w-4xl mb-10 leading-relaxed">{{ slide.desc }}</p>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <a :href="loginRoute" class="bg-[#32424D] text-[#E8D258] text-2xl font-bold px-10 py-5 rounded-full hover:scale-105 transition-transform shadow-lg">
                  Empezar ahora
                </a>
                <a href="#servicios" class="bg-white text-[#32424D] border-3 border-[#32424D] text-2xl font-bold px-10 py-5 rounded-full hover:bg-gray-50 transition-colors shadow-md">
                    Saber más
                </a>
            </div>
          </div>
        </div>
      </transition>
    </div>

    <button @click="prev" class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/90 p-4 rounded-full text-[#32424D] z-30 shadow-xl hover:bg-white transition-colors">
      <i class="bi bi-chevron-left text-3xl"></i>
    </button>
    <button @click="next" class="absolute right-6 top-1/2 -translate-y-1/2 bg-white/90 p-4 rounded-full text-[#32424D] z-30 shadow-xl hover:bg-white transition-colors">
      <i class="bi bi-chevron-right text-3xl"></i>
    </button>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3 z-30">
      <button 
        v-for="(_, i) in slides" 
        :key="i"
        @click="activeSlide = i"
        :class="activeSlide === i ? 'bg-[#32424D] w-8' : 'bg-[#32424D]/50 w-3'"
        class="h-3 rounded-full transition-all duration-300"
      ></button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps(['loginRoute', 'bannerImg', 'logoImg', 'storageImg']);

const activeSlide = ref(0);
const slides = [
  { image: props.bannerImg, title: 'Tu comunidad, <br><span class=\'text-[#bc6a50]\'>más viva que nunca.</span>', desc: 'Únete a Tenderete: el lugar donde compartir momentos, hacer nuevos amigos y disfrutar de actividades pensadas para ti.' },
  { image: props.storageImg, title: 'Actividades <br><span class=\'text-[#bc6a50]\'>para todos.</span>', desc: 'Talleres, paseos y charlas pensadas específicamente para tu bienestar y diversión.' },
  { image: props.logoImg, title: 'Un entorno <br><span class=\'text-[#bc6a50]\'>cerca de ti.</span>', desc: 'Diseñado con cariño y respeto, pensando siempre en tu comodidad y seguridad.' }
];

let timer = null;
const next = () => activeSlide.value = (activeSlide.value + 1) % slides.length;
const prev = () => activeSlide.value = (activeSlide.value - 1 + slides.length) % slides.length;

onMounted(() => {
  timer = setInterval(next, 8000);
});

onBeforeUnmount(() => {
  clearInterval(timer);
});

const handleError = (e) => {
  console.error("Fallo al cargar imagen:", e.target.src);
  e.target.src = 'https://via.placeholder.com/1920x1080?text=Error+Carga+Imagen';
};
</script>