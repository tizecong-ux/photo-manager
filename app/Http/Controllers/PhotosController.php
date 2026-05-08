<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoStoreRequest;
use App\Services\PhotoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PhotosController extends Controller
{
    function __construct(protected PhotoService $service) {}

    /**
     * 写真一覧画面
     *
     * @return View
     */
    public function index(): View
    {
        $userId = auth()->user();
        $photos = $this->service->getByUserDesc($userId);

        return view('photos.index', compact('photos'));
    }


    /**
     * 写真アップロードフォーム画面
     *
     * @return View
     */
    public function create(): View
    {
        return view('photos.create');
    }

    /**
     * 写真アップロード処理
     *
     * @param PhotoStoreRequest $request
     * @param PhotoService $service
     * @return RedirectResponse
     */
    public function store(PhotoStoreRequest $request, PhotoService $service): RedirectResponse
    {
        try {
            $service->create($request->validated(), $request->file('image'));

            return redirect()
                ->route('photos.index')
                ->with('success', '写真のアップロードが終了しました。');
        } catch (\Exception $e) {
            report($e);

            return redirect()
                ->route('photos.index')
                ->with('error', '写真のアップロードに失敗しました。');
        }
    }
}
