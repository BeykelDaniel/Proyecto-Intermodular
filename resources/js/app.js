import './bootstrap';

import { createApp } from 'vue';
import Alpine from 'alpinejs';

import NotificacionesAmistad from './components/NotificacionesAmistad.vue';
import CalendarioNavbar from './components/CalendarioNavbar.vue';
import ChatPrivado from './components/ChatPrivado.vue';
import ForoActividad from './components/ForoActividad.vue';

window.Alpine = Alpine;
Alpine.start();

const app = createApp({});

app.component('notificaciones-amistad', NotificacionesAmistad);
app.component('calendario-navbar', CalendarioNavbar);
app.component('chat-privado', ChatPrivado);
app.component('foro-actividad', ForoActividad);

app.mount('#app');
