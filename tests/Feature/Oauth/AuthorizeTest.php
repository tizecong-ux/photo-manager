<?php

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

test('OAuth未認証の場合はOAuth認可リンクが表示される', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('photos.index'));

    $response->assertSee('OAuth認可ページへ');
});

test('OAuth認証済みの場合はOAuth認可リンクが表示されない', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->withSession([config('oauth_session.access_token_key') => 'TOKEN123'])
        ->get(route('photos.index'));

    $response->assertDontSee('OAuth認可ページへ');
});

test('認証済みユーザーはOAuth認可URLへリダイレクトされる', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('oauth.authorize'));

    $response->assertRedirect();

    $redirectUrl = $response->headers->get('Location');
    $query = parse_url($redirectUrl, PHP_URL_QUERY);
    parse_str($query, $params);

    expect($redirectUrl)->toStartWith(config('oauth_authorize.authorize_url') . '?');
    expect($params)->toEqual([
        'client_id' => config('oauth_authorize.client_id'),
        'response_type' => config('oauth_authorize.response_type'),
        'redirect_uri' => config('oauth_authorize.redirect_uri'),
        'scope' => config('oauth_authorize.scope'),
    ]);
});

test('codeなしのOAuthコールバックは写真一覧へリダイレクトされる', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('oauth.callback'));

    $response->assertRedirect(route('photos.index', absolute: false));
});

test('code付きのOAuthコールバックはアクセストークンをセッションに保存する', function () {
    Http::fake([
        config('oauth_token.token_url') => Http::response(['access_token' => 'TOKEN123'], 200),
    ]);

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('oauth.callback', ['code' => 'authcode']));

    $response->assertRedirect(route('photos.index', absolute: false));
    expect(session(config('oauth_session.access_token_key')))->toBe('TOKEN123');
});

test('OAuthコールバック失敗時はエラーをフラッシュして写真一覧へリダイレクトする', function () {
    Http::fake([
        config('oauth_token.token_url') => Http::response(['error' => 'invalid_grant'], 400),
    ]);

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('oauth.callback', ['code' => 'invalid']));

    $response->assertRedirect(route('photos.index', absolute: false));
    expect(session('error'))->toBe('OAuthアクセストークンの取得に失敗しました。');
});
