<?php

namespace App\Repositories;

use App\Models\Photo;

class PhotoRepository
{
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
