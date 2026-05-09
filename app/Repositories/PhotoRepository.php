<?php

namespace App\Repositories;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Collection;

class PhotoRepository
{
    /**
     * 写真一覧を取得する
     *
     * @param int $userId
     * @param bool $isTweeted
     * @return Collection
     */
    public function getByUserDesc(int $userId, bool $isTweeted = false): Collection
    {
        return Photo::with('tweet')
            ->where('user_id', $userId)
            // Tweet済みかどうかで絞り込み
            ->when($isTweeted, function ($query) {
                $query->whereHas('tweet');
            })
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * 写真を保存する
     *
     * @param array $data
     * @return Photo
     */
    public function create(array $data): Photo
    {
        return Photo::create($data);
    }
}
