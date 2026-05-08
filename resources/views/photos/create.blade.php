<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-base text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('photos.index') }}"
                            class="inline-flex items-center px-5 py-3 text-base font-semibold text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            一覧画面へ戻る
                        </a>
                    </div>
                    <h1 class="text-2xl font-semibold text-center">写真アップロード画面</h1>

                    @if ($errors->any())
                        <div class="mt-4 rounded-md bg-red-50 p-4 text-base text-red-700">
                            <ul class="mt-2 list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('photos.store') }}" enctype="multipart/form-data"
                        class="mt-6 space-y-8">
                        @csrf

                        <div>
                            <label for="title" class="block text-base font-medium text-gray-700">
                                <span class="inline-flex items-center gap-1">
                                    <span class="text-red-500">*</span>
                                    タイトル
                                </span>
                            </label>
                            <input id="title" name="title" type="text" value="{{ old('title') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label for="image" class="block text-base font-medium text-gray-700">
                                <span class="inline-flex items-center gap-1">
                                    <span class="text-red-500">*</span>
                                    画像ファイル
                                </span>
                            </label>
                            <input id="image" name="image" type="file" accept="image/*"
                                class="mt-1 block w-full text-base text-gray-500" />
                        </div>

                        <div>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                アップロードする
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
