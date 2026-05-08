<?php

use App\Models\User;

test('ログイン画面が表示されること', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('ログイン画面で認証できること', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('photos.index', absolute: false));
});

test('無効なパスワードでは認証できないこと', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('ログアウトできること', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
