<header class="bg-[#141414] p-4 flex justify-between items-center border-b border-gray-700">
    <div class="text-lg font-semibold">Hello, {{ Auth::user()->name ?? 'User' }}</div>

    <div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="bg-green-500 hover:bg-green-600 text-black px-4 py-1 rounded flex items-center"
            >
                <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> Logout
            </button>
        </form>
    </div>
</header>
