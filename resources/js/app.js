import '@vue-flow/core/dist/style.css';
import '@vue-flow/core/dist/theme-default.css';

// Chargement de bootstrap (CSRF, axios, etc.)
import './bootstrap';

// Alpine.js (utile pour UI légère)
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Axios global (optionnel si tu veux utiliser dans Vue)
import axios from 'axios';
window.axios = axios;

// Vue.js setup
import { createApp } from 'vue';

// Composant Vue personnalisé
import Editor from './Pages/Automations/Editor.vue';

// Création de l'app Vue et montage
const app = createApp({});
app.component('editor', Editor); // 👈 Nom en kebab dans le HTML : <editor>
app.mount('#app');

// FullCalendar (optionnel)
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            events: '/your-events-endpoint',
        });
        calendar.render();
    }
});
