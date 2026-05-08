<?php

use App\Http\Controllers\PhotosController;
use Illuminate\Support\Facades\Route;

// TOPページにアクセスした際に、ログインページへリダイレクトするルート
Route::get('/', function () {
    return redirect()->route('login');
});

// ログイン必須ページ
Route::middleware('auth')->prefix('photos')->name('photos.')->group(function () {
    // 写真一覧画面
    Route::get('/', [PhotosController::class, 'index'])->name('index');
    // 写真アップロード画面
    Route::get('/create', [PhotosController::class, 'create'])->name('create');
    Route::post('/', [PhotosController::class, 'store'])->name('store');
});

require __DIR__ . '/auth.php';
