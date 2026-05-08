<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
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

                    <a href="{{ route('photos.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        写真アップロード画面
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
