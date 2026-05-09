<?php

namespace App\Http\Controllers;

use App\Services\TweetService;
use App\Services\PhotoService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TweetsController extends Controller
{
    public function __construct(
        protected TweetService $tweetService,
        protected PhotoService $photoService
    ) {}

    /**
     * Tweet一覧画面
     * 
     * @return View
     */
    public function index(): View
    {
        // Tweet済みの写真を取得
        $userId = auth()->user()->id;
        $tweetedPhotos = $this->photoService->getByUserDesc($userId, true);

        return view('tweets.index', compact('tweetedPhotos'));
    }

    /**
     * Tweet作成処理
     *
     * @param Request $request
     * @return View | RedirectResponse
     */
    public function store(Request $request): View | RedirectResponse
    {
        $photoId = $request->input('photo_id');
        $userId = auth()->user()->id;

        $accessToken = session(config('oauth_session.access_token_key'));
        if (!is_string($accessToken) || $accessToken === '') {
            return redirect()
                ->route('photos.index')
                ->with('error', 'OAuth認証が必要です。');
        }

        // Tweet可能か判定
        if (!$this->tweetService->canTweet($photoId, $userId)) {
            return redirect()
                ->route('photos.index')
                ->with('error', 'この写真はツイートできません。');
        }

        $tweet = $this->tweetService->postTweet($photoId, $accessToken);
        if (! $tweet) {
            return redirect()
                ->route('photos.index')
                ->with('error', 'ツイートに失敗しました。');
        }

        return redirect()
            ->route('tweets.index')
            ->with('success', 'ツイートが完了しました。');
    }
}
