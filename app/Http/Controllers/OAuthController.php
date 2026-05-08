<?php

namespace App\Http\Controllers;

use App\Services\OAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OAuthController extends Controller
{
    public function __construct(protected OAuthService $oauthService) {}

    public function authorize(): RedirectResponse
    {
        return redirect($this->oauthService->buildAuthorizeUrl());
    }

    public function callback(Request $request): RedirectResponse
    {
        $code = $request->query('code');

        if (!is_string($code) || $code === '') {
            return redirect()->route('photos.index');
        }

        try {
            $accessToken = $this->oauthService->getAccessToken($code);
            $sessionKey = config('oauth_session.access_token_key');
            session([$sessionKey => $accessToken]);

            return redirect()->route('photos.index');
        } catch (\Exception $e) {
            report($e);

            return redirect()
                ->route('photos.index')
                ->with('error', 'OAuthアクセストークンの取得に失敗しました。');
        }
    }
}
