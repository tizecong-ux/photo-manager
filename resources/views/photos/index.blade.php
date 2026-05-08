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

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('photos.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            写真アップロード画面
                        </a>

                        @if (!$isAuthenticated)
                            <a href="{{ route('oauth.authorize') }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                OAuth認可ページへ
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($photos as $photo)
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                            <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->title }}"
                                class="h-full w-full object-cover transition duration-200 hover:scale-105" />
                        </div>
                        <div class="px-4 py-4">
                            <h2 class="text-base font-semibold text-gray-900">{{ $photo->title }}</h2>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-sm text-gray-500">
                        まだアップロードされた写真はありません。
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
