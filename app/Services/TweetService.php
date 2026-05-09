<?php

namespace App\Services;

use App\Models\Photo;
use App\Models\Tweet;
use App\Repositories\TweetRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TweetService
{
    public function __construct(protected TweetRepository $repository) {}

    /**
     * Tweetを作成する
     *
     * @param array $data
     * @return Tweet
     */
    public function create(array $data): Tweet
    {
        return $this->repository->create($data);
    }

    /**
     * 指定された写真がTweet可能か判定する
     *
     * 条件:
     * - 対象写真が指定されたユーザーに紐づいている
     * - まだTweetされていない()
     *
     * @param int $photoId
     * @param int $userId
     * @return bool
     */
    public function canTweet(int $photoId, int $userId): bool
    {
        $photoExists = Photo::where('id', $photoId)
            ->where('user_id', $userId)
            ->exists();

        if (! $photoExists) {
            return false;
        }

        if ($this->repository->existsByPhotoId($photoId)) {
            return false;
        }

        return true;
    }

    /**
     * 連携アプリにTweetを投稿し、成功したらTweetテーブルへ登録する
     *
     * @param int $photoId
     * @param string $accessToken
     * @return Tweet|null
     */
    public function postTweet(int $photoId, string $accessToken): ?Tweet
    {
        $photo = Photo::findOrFail($photoId);

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$accessToken}",
            'Content-Type' => 'application/json',
        ])->post(config('oauth_tweet.api_url'), [
            'text' => $photo->title,
            'url' => url(Storage::url($photo->image_path)),
        ]);

        if ($response->status() !== 201) {
            return null;
        }

        return $this->repository->create(['photo_id' => $photo->id]);
    }
}
