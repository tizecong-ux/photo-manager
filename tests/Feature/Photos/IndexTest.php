<?php

use App\Models\Photo;
use App\Models\User;

test('ログインユーザーに紐づく写真が表示される。並び順はアップロード順で表示される。', function () {
    $user = User::factory()->create();

    Photo::create([
        'user_id' => $user->id,
        'title' => '最新の写真',
        'image_path' => 'photos/recent.jpg',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    Photo::create([
        'user_id' => $user->id,
        'title' => '古い写真',
        'image_path' => 'photos/old.jpg',
        'created_at' => now()->subDay(),
        'updated_at' => now()->subDay(),
    ]);

    $response = $this->actingAs($user)->get(route('photos.index'));

    $response->assertStatus(200);
    $response->assertViewHas('photos');
    $response->assertSee('最新の写真');
    $response->assertSee('古い写真');
    $response->assertSeeInOrder(['最新の写真', '古い写真']);
});

test('他ユーザーの写真は一覧に表示されない', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    Photo::create([
        'user_id' => $otherUser->id,
        'title' => '他人の写真',
        'image_path' => 'photos/other.jpg',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $response = $this->actingAs($user)->get(route('photos.index'));

    $response->assertStatus(200);
    $response->assertDontSee('他人の写真');
});

test('未認証ユーザーは写真一覧画面にアクセスできずログインページにリダイレクトされる', function () {
    $response = $this->get(route('photos.index'));

    $response->assertRedirect(route('login', absolute: false));
});
