import './bootstrap';
import { createApp } from 'vue';
import Alpine from 'alpinejs';

// Iniciar Alpine
window.Alpine = Alpine;
Alpine.start();

// Crear Aplicación Vue
const app = createApp({});

// Registro de Componentes
import CarrouselHome from './components/CarrouselHome.vue';
import NotificacionesAmistad from './components/NotificacionesAmistad.vue';
import CalendarioNavbar from './components/CalendarioNavbar.vue';
import ChatPrivado from './components/ChatPrivado.vue';
import ForoActividad from './components/ForoActividad.vue';

app.component('carrousel-home', CarrouselHome);
app.component('notificaciones-amistad', NotificacionesAmistad);
app.component('calendario-navbar', CalendarioNavbar);
app.component('chat-privado', ChatPrivado);
app.component('foro-actividad', ForoActividad);

// Montar en el ID app
app.mount('#app');