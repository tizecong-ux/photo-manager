<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />

            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($photos as $photo)
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="px-4 py-4 space-y-3">
                            <h2 class="text-base font-semibold text-gray-900">{{ $photo->title }}</h2>
                        </div>
                        <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                            <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->title }}"
                                class="h-full w-full object-cover transition duration-200" />
                        </div>
                        @if ($isAuthenticated && !$photo->tweet)
                            <div class="px-4 py-4">
                                <form method="POST" action="{{ route('tweets.store') }}">
                                    @csrf
                                    <input type="hidden" name="photo_id" value="{{ $photo->id }}">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                        Tweetする
                                    </button>
                                </form>
                            </div>
                        @endif
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
