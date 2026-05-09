<?php

use App\Models\Photo;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

test('OAuthアクセストークンがないとTweet投稿できない', function () {
    $user = User::factory()->create();

    $photo = Photo::create([
        'user_id' => $user->id,
        'title' => 'テスト写真',
        'image_path' => 'photos/test.png',
    ]);

    $response = $this->actingAs($user)
        ->post(route('tweets.store'), ['photo_id' => $photo->id]);

    $response->assertRedirect(route('photos.index', absolute: false));
    $response->assertSessionHas('error', 'OAuth認証が必要です。');

    $this->assertDatabaseMissing('tweets', ['photo_id' => $photo->id]);
});

test('すでにTweet済みの写真は投稿できない', function () {
    $user = User::factory()->create();

    $photo = Photo::create([
        'user_id' => $user->id,
        'title' => 'テスト写真',
        'image_path' => 'photos/test.png',
    ]);

    Tweet::create(['photo_id' => $photo->id]);

    $response = $this->actingAs($user)
        ->withSession([config('oauth_session.access_token_key') => 'TOKEN123'])
        ->post(route('tweets.store'), ['photo_id' => $photo->id]);

    $response->assertRedirect(route('photos.index', absolute: false));
    $response->assertSessionHas('error', 'この写真はツイートできません。');

    $this->assertDatabaseCount('tweets', 1);
});

test('Tweet投稿成功時は外部API呼び出しとTweetテーブル作成が行われる', function () {
    $user = User::factory()->create();

    $photo = Photo::create([
        'user_id' => $user->id,
        'title' => 'テスト写真',
        'image_path' => 'photos/test.png',
    ]);

    $accessToken = 'TOKEN123';
    Http::fake([
        config('oauth_tweet.api_url') => Http::response([], 201),
    ]);

    $response = $this->actingAs($user)
        ->withSession([config('oauth_session.access_token_key') => $accessToken])
        ->post(route('tweets.store'), ['photo_id' => $photo->id]);

    $response->assertRedirect(route('tweets.index', absolute: false));
    $response->assertSessionHas('success', 'ツイートが完了しました。');

    $this->assertDatabaseHas('tweets', ['photo_id' => $photo->id]);

    Http::assertSent(function ($request) use ($accessToken, $photo) {
        return $request->url() === config('oauth_tweet.api_url')
            && $request->hasHeader('Authorization')
            && $request->header('Authorization')[0] === "Bearer {$accessToken}"
            && $request['text'] === $photo->title
            && $request['url'] === url(Storage::url($photo->image_path));
    });
});
