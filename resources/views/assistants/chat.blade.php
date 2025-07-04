@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-6">
    <div class="bg-[#333333] text-white rounded-xl shadow-xl p-6">
        <h2 class="text-2xl font-semibold mb-4 flex items-center gap-2">
            <div class="bg-green-500 p-2 rounded-full">
                <i class="fas fa-robot"></i>
            </div>
            <span>AI Assistant</span>
        </h2>

        <!-- Zone chat -->
        <div id="chat-box" class="bg-[#2a2a2a] h-72 overflow-y-auto p-4 rounded-lg mb-4 space-y-3"></div>

        <!-- Input -->
        <div class="flex items-center gap-2">
            <input id="prompt" type="text" class="w-full px-4 py-2 bg-[#222222] border border-gray-600 rounded text-white placeholder-gray-400" placeholder="Type your request..." />
            <button id="send" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"><i class="fas fa-paper-plane"></i></button>
            <button onclick="startListening()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"><i class="fas fa-microphone"></i></button>
        </div>
    </div>

   

    <!-- Assistants section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
        <!-- Humanoid -->
        <div class="bg-[#333333] p-6 rounded-xl text-center shadow-md">
            <div class="text-5xl text-green-400 mb-3">
                <i class="fab fa-android"></i>
            </div>
            <h3 class="text-xl font-bold">Humanoid Assistant</h3>
            <p class="text-green-400 mt-1 font-medium">Online</p>
            <p class="text-sm mt-2 text-gray-300">Dispatch for inspections, tours, or tasks.</p>
            <button class="mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                <i class="fas fa-play mr-2"></i> Dispatch
            </button>
        </div>

        <!-- Ecosystem -->
        <div class="bg-[#333333] p-6 rounded-xl text-center shadow-md">
            <h3 class="text-xl font-bold mb-2">Ecosystem Assistant</h3>
            <p class="text-sm text-gray-300 mb-4">Connect with 3rd-party platforms.</p>
            <ul class="text-left text-green-300 space-y-2 ml-4">
                <li><i class="fas fa-network-wired mr-2"></i> Cisco Switch</li>
                <li><i class="fab fa-google mr-2"></i> Google Assistant</li>
                <li><i class="fas fa-store mr-2"></i> Marketplace</li>
            </ul>
            <button class="mt-6 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                <i class="fas fa-puzzle-piece mr-2"></i> Explore Integrations
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('send').addEventListener('click', sendPrompt);

function sendPrompt() {
    const prompt = document.getElementById('prompt').value;
    const chatBox = document.getElementById('chat-box');

    if (!prompt.trim()) return;

    chatBox.innerHTML += `<div class="text-right"><span class="bg-green-600 px-4 py-2 rounded-xl inline-block">${prompt}</span></div>`;
    chatBox.innerHTML += `<div id="typing" class="text-left text-gray-400 italic">AI is typing...</div>`;
    chatBox.scrollTop = chatBox.scrollHeight;

    fetch('{{ route("assistants.send") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ prompt })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('typing').remove();
        chatBox.innerHTML += `<div class="text-left"><span class="bg-[#444444] px-4 py-2 rounded-xl inline-block">${data.response}</span></div>`;
        document.getElementById('prompt').value = '';
        chatBox.scrollTop = chatBox.scrollHeight;
    });
}

// 🎙️ Micro
function startListening() {
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = 'en-US';
    recognition.start();

    recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        document.getElementById('prompt').value = transcript;
    };
}
</script>
@endpush
