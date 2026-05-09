<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center gap-3">
                <a href="{{ route('photos.index') }}" @class([
                    'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2',
                    'bg-indigo-600 hover:bg-indigo-700' => !request()->routeIs('photos.index'),
                    'bg-gray-400 cursor-not-allowed pointer-events-none' => request()->routeIs(
                        'photos.index'),
                ])>
                    写真一覧画面
                </a>

                <a href="{{ route('photos.create') }}" @class([
                    'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2',
                    'bg-sky-600 hover:bg-sky-700' => !request()->routeIs('photos.create'),
                    'bg-gray-400 cursor-not-allowed pointer-events-none' => request()->routeIs(
                        'photos.create'),
                ])>
                    写真アップロード画面
                </a>

                <a href="{{ route('tweets.index') }}" @class([
                    'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2',
                    'bg-green-600 hover:bg-green-700' => !request()->routeIs('tweets.index'),
                    'bg-gray-400 cursor-not-allowed pointer-events-none' => request()->routeIs(
                        'tweets.index'),
                ])>
                    Tweet一覧画面
                </a>

                @auth
                    @if (!session(config('oauth_session.access_token_key')))
                        <a href="{{ route('oauth.authorize') }}" @class([
                            'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2',
                            'bg-orange-600 hover:bg-orange-700' => !request()->routeIs(
                                'oauth.authorize'),
                            'bg-gray-400 cursor-not-allowed pointer-events-none' => request()->routeIs(
                                'oauth.authorize'),
                        ])>
                            OAuth認可ページへ
                        </a>
                    @endif
                @endauth
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('ログアウト') }}
                </button>
            </form>
        </div>
    </div>
</nav>
