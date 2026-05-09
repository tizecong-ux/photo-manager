<?php

namespace App\Repositories;

use App\Models\Tweet;

class TweetRepository
{
    /**
     * Tweetを作成する
     *
     * @param array $data
     * @return Tweet
     */
    public function create(array $data): Tweet
    {
        return Tweet::create($data);
    }

    /**
     * 指定した写真が既にTweet済みかどうかを判定する
     *
     * @param int $photoId
     * @return bool
     */
    public function existsByPhotoId(int $photoId): bool
    {
        return Tweet::where('photo_id', $photoId)->exists();
    }
}
