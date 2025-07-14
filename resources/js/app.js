// 🌐 Styles pour Vue Flow
import '@vue-flow/core/dist/style.css'
import '@vue-flow/core/dist/theme-default.css'

// 📦 Bootstrap, axios et Alpine
import './bootstrap'
import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

import axios from 'axios'
window.axios = axios

// 🧠 Vue.js
import { createApp } from 'vue'

// 🧩 Composants personnalisés
import Editor from './Pages/Automations/Editor.vue'
import AutomationCreate from './Pages/Automations/AutomationCreate.vue'
import FlowEditor from './Pages/Automations/FlowEditor.vue'
import AutomationSelector from './Pages/Automations/AutomationSelector.vue' // ✅ Ajouté ici

// 🧰 Vue Flow
import { VueFlow } from '@braks/vue-flow'

// 🚀 Création de l'app Vue
const app = createApp({})
app.use(VueFlow)

// 📌 Enregistrement des composants globaux
app.component('editor', Editor)
app.component('automation-create', AutomationCreate)
app.component('flow-editor', FlowEditor)
app.component('automation-selector', AutomationSelector) // ✅ Important !

// 🎯 Montage sur l'élément avec id="app"
app.mount('#app')

// 📅 FullCalendar (optionnel)
import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar')
    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            events: '/your-events-endpoint',
        })
        calendar.render()
    }
})
