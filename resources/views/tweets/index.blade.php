<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />

            <div class="mt-6 space-y-4">
                @forelse ($tweetedPhotos as $photo)
                    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm px-4 py-4 space-y-2">
                        <p class="text-base font-semibold text-gray-900">タイトル : {{ $photo->title }}</p>
                        <p class="text-base font-semibold text-gray-900">URL :
                            <a href="{{ url(Storage::url($photo->image_path)) }}" target="_blank" rel="noopener noreferrer"
                                class="text-blue-600 hover:text-blue-800 break-all">
                                {{ url(Storage::url($photo->image_path)) }}
                            </a>
                        </p>
                    </div>
                @empty
                    <div
                        class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-sm text-gray-500">
                        まだTweetされた投稿はありません。
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
