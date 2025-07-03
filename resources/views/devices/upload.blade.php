<form action="{{ route('devices.import') }}" method="POST" enctype="multipart/form-data" class="mb-6 flex items-center gap-4">
    @csrf
    <input type="file" name="csv_file"
           class="text-white bg-gray-800 border border-gray-600 rounded px-4 py-2 w-1/3">
    <button type="submit"
            class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-400 transition-all">
        Import Devices
    </button>
</form>