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
     * @param User $user
     * @return Collection
     */
    public function getByUserDesc(User $user): Collection
    {
        return $this->repository->getByUserDesc($user->id);
    }

    /**
     * 写真を保存する
     *
     * @param array $data
     * @param UploadedFile $image
     * @param User $user
     * @return Photo
     */
    public function create(array $data, UploadedFile $image): Photo
    {
        $path = Storage::disk('public')->putFile('photos', $image);

        return $this->repository->create([
            'title' => $data['title'],
            'image_path' => $path,
        ]);
    }
}
