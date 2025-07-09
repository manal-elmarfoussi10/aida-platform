@if (session('success'))
    <div class="mb-4 bg-green-800 text-green-100 p-3 rounded shadow">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 bg-red-800 text-red-100 p-3 rounded shadow">
        <strong>Error:</strong>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif