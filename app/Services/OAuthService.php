<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OAuthService
{
    public function buildAuthorizeUrl(): string
    {
        $query = http_build_query([
            'client_id' => config('oauth_authorize.client_id'),
            'response_type' => config('oauth_authorize.response_type'),
            'redirect_uri' => config('oauth_authorize.redirect_uri'),
            'scope' => config('oauth_authorize.scope'),
        ]);

        return config('oauth_authorize.authorize_url') . '?' . $query;
    }

    public function getAccessToken(string $code): string
    {
        $response = Http::asForm()->post(config('oauth_token.token_url'), [
            'code' => $code,
            'client_id' => config('oauth_token.client_id'),
            'client_secret' => config('oauth_token.client_secret'),
            'redirect_uri' => config('oauth_token.redirect_uri'),
            'grant_type' => config('oauth_token.grant_type'),
        ]);

        $response->throw();

        $accessToken = $response->json('access_token');

        if (!is_string($accessToken) || $accessToken === '') {
            throw new \RuntimeException('access_token is missing from OAuth token response.');
        }

        return $accessToken;
    }
}
