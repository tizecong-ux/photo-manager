<?php

use App\Models\Photo;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

test('Tweet済みの写真が一覧に表示される', function () {
    $user = User::factory()->create();

    $photo = Photo::create([
        'user_id' => $user->id,
        'title' => 'テスト写真',
        'image_path' => 'photos/test.png',
    ]);

    Tweet::create(['photo_id' => $photo->id]);

    $response = $this->actingAs($user)
        ->get(route('tweets.index'));

    $response->assertOk();
    $response->assertSeeText('タイトル : ' . $photo->title);
    $response->assertSeeText(url(Storage::url($photo->image_path)));
});

test('Tweetされていない写真はTweet一覧に表示されない', function () {
    $user = User::factory()->create();

    Photo::create([
        'user_id' => $user->id,
        'title' => '未ツイート写真',
        'image_path' => 'photos/untweeted.png',
    ]);

    $response = $this->actingAs($user)
        ->get(route('tweets.index'));

    $response->assertOk();
    $response->assertSeeText('まだTweetされた投稿はありません。');
    $response->assertDontSeeText('未ツイート写真');
});

test('別アカウントのTweetは一覧に表示されない', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $photo = Photo::create([
        'user_id' => $otherUser->id,
        'title' => '他人の写真',
        'image_path' => 'photos/other.png',
    ]);

    Tweet::create(['photo_id' => $photo->id]);

    $response = $this->actingAs($user)
        ->get(route('tweets.index'));

    $response->assertOk();
    $response->assertSeeText('まだTweetされた投稿はありません。');
    $response->assertDontSeeText('他人の写真');
});
