<?php

namespace App\Services;

use App\Models\Photo;
use App\Models\User;
use App\Repositories\PhotoRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Database\Eloquent\Collection;

class PhotoService
{
    public function __construct(protected PhotoRepository $repository) {}

    /**
     * 写真一覧を取得する
     *
     * @param int $userId
     * @param bool $isTweeted
     * @return Collection
     */
    public function getByUserDesc(int $userId, bool $isTweeted = false): Collection
    {
        return $this->repository->getByUserDesc($userId, $isTweeted);
    }

    /**
     * 写真を保存する
     *
     * @param array $data
     * @param UploadedFile $image
     * @param int $userId
     * @return Photo
     */
    public function create(array $data, UploadedFile $image, int $userId): Photo
    {
        $path = Storage::disk('public')->putFile('photos', $image);

        return $this->repository->create([
            'title' => $data['title'],
            'image_path' => $path,
            'user_id' => $userId,
        ]);
    }
}
