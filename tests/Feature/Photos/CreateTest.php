<?php

use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('ログインユーザーは写真アップロード画面を表示できる', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('photos.create'));

    $response->assertStatus(200);
    $response->assertSee('写真アップロード画面');
});

test('戻るボタンが一覧画面に遷移するリンクが存在する', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('photos.create'));

    $response->assertStatus(200);
    $response->assertSee('href="' . route('photos.index') . '"', false);
});

test('未認証ユーザーは写真アップロード画面にアクセスできずログインページにリダイレクトされる', function () {
    $response = $this->get(route('photos.create'));

    $response->assertRedirect(route('login', absolute: false));
});

test('タイトルがNULLの場合はバリデーションが発生する', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('photos.store'), [
        'title' => '',
        'image' => UploadedFile::fake()->image('photo.jpg'),
    ]);

    $response->assertSessionHasErrors(['title']);
});

test('画像ファイルがNULLの場合はバリデーションが発生する', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('photos.store'), [
        'title' => 'テストタイトル',
    ]);

    $response->assertSessionHasErrors(['image']);
});

test('画像ファイルは画像形式でない場合はバリデーションが発生する', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('photos.store'), [
        'title' => 'テストタイトル',
        'image' => UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
    ]);

    $response->assertSessionHasErrors(['image']);
});

test('写真が正常にアップロードされるとデータが作成されること', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('photos.store'), [
        'title' => 'テストタイトル',
        'image' => UploadedFile::fake()->image('photo.jpg'),
    ]);

    $response->assertRedirect(route('photos.index', absolute: false));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('photos', [
        'title' => 'テストタイトル',
    ]);

    $photo = Photo::where('title', 'テストタイトル')->first();
    $this->assertNotNull($photo);
    Storage::disk('public')->assertExists($photo->image_path);
});
