import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

// ✅ Écoute du statut de l’assistant (channel assistant-status)
window.Echo.channel('assistant-status')
    .listen('.assistant.status', (e) => {
        console.log('🟢 Assistant status updated:', e.assistant);

        // Optionnel : mets à jour une UI si besoin, exemple :
        const statusEl = document.getElementById('assistant-status');
        if (statusEl) {
            statusEl.textContent = e.assistant.status;
        }
    });

// ✅ Écoute de la réponse AI en temps réel (channel chat)
window.Echo.channel('chat')
    .listen('.ai.response', (e) => {
        console.log('💬 AI responded:', e.response);

        const chatBox = document.getElementById('chat-box');
        if (chatBox) {
            chatBox.innerHTML += `<div class="text-left">
                <span class="bg-[#444444] px-4 py-2 rounded-xl inline-block">${e.response}</span>
            </div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // Supprime le loader "AI is typing..." s'il existe
        const typing = document.getElementById('typing');
        if (typing) typing.remove();
    });

