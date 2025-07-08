import './bootstrap';

import Alpine from 'alpinejs';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

import { createApp } from 'vue';
import Editor from './Pages/Automations/Editor.vue';
import axios from 'axios';

window.Alpine = Alpine;
Alpine.start();
window.axios = axios;

// Mount Vue
const app = createApp({});
app.component('Editor', Editor);
app.mount('#app');

// Optional: FullCalendar init if needed
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