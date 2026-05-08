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
     * @return Collection
     */
    public function getByUserDesc(int $userId): Collection
    {
        return Photo::where('user_id', $userId)
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
