<?php

use App\Http\Controllers\PhotosController;
use Illuminate\Support\Facades\Route;

// TOPページにアクセスした際に、ログインページへリダイレクトするルート
Route::get('/', function () {
    return redirect()->route('login');
});

// ログイン必須ページ
Route::middleware('auth')->prefix('photos')->name('photos.')->group(function () {
    Route::get('/', [PhotosController::class, 'index'])->name('index');
});

require __DIR__ . '/auth.php';
