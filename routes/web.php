<?php

use App\Http\Controllers\OAuthController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\TweetsController;
use Illuminate\Support\Facades\Route;

// TOPページにアクセスした際に、ログインページへリダイレクトするルート
Route::get('/', function () {
    return redirect()->route('login');
});

// ログイン必須ページ
Route::middleware('auth')->group(function () {
    // 写真関連
    Route::prefix('photos')->name('photos.')->group(function () {
        // 写真一覧画面
        Route::get('/', [PhotosController::class, 'index'])->name('index');
        // 写真アップロード画面
        Route::get('/create', [PhotosController::class, 'create'])->name('create');
        Route::post('/', [PhotosController::class, 'store'])->name('store');
    });

    // OAuth認可
    Route::prefix('oauth')->name('oauth.')->group(function () {
        // OAuth認可ページへの遷移
        Route::get('/authorize', [OAuthController::class, 'authorize'])->name('authorize');
        // OAuthコールバック
        Route::get('/callback', [OAuthController::class, 'callback'])->name('callback');
    });

    // Tweet関連
    Route::prefix('tweets')->name('tweets.')->group(function () {
        // Tweet一覧画面
        Route::get('/', [TweetsController::class, 'index'])->name('index');
        // Tweet作成処理
        Route::post('/', [TweetsController::class, 'store'])->name('store');
    });
});

require __DIR__ . '/auth.php';
