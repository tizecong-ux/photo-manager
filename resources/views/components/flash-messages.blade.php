@if (session('success') || session('error'))
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        @if (session('success'))
            <div class="rounded-md bg-green-50 p-4 text-base text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-md bg-red-50 p-4 text-base text-red-700">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endif
