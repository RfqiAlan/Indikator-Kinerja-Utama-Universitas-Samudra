<?php

namespace App\Http\Controllers;

use App\Models\GoogleDriveToken;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GoogleDriveOauthController extends Controller
{
    public function redirectToGoogle(Request $request): RedirectResponse
    {
        $request->session()->put('google_drive_intended', url()->previous());

        $client = $this->makeClient();
        return redirect()->away($client->createAuthUrl());
    }

    public function handleCallback(Request $request): RedirectResponse
    {
        if ($request->get('error')) {
            return redirect()->route('dashboard')->with('error', 'Login Google dibatalkan.');
        }

        $code = $request->get('code');
        if (!$code) {
            return redirect()->route('dashboard')->with('error', 'Kode otorisasi Google tidak ditemukan.');
        }

        $client = $this->makeClient();
        $token = $client->fetchAccessTokenWithAuthCode($code);

        if (isset($token['error'])) {
            return redirect()->route('dashboard')->with('error', 'Gagal login Google: ' . $token['error_description']);
        }

        $userId = $request->user()->id;
        $existing = GoogleDriveToken::where('user_id', $userId)->first();
        $refreshToken = $token['refresh_token'] ?? ($existing?->refresh_token);

        GoogleDriveToken::updateOrCreate(
            ['user_id' => $userId],
            [
                'access_token' => $token['access_token'] ?? '',
                'refresh_token' => $refreshToken,
                'token_type' => $token['token_type'] ?? 'Bearer',
                'scopes' => $token['scope'] ?? null,
                'expires_at' => isset($token['expires_in']) ? now()->addSeconds($token['expires_in']) : null,
            ]
        );

        $redirect = $request->session()->pull('google_drive_intended', route('dashboard'));
        return redirect($redirect)->with('success', 'Google Drive berhasil dihubungkan.');
    }

    public function disconnect(Request $request): RedirectResponse
    {
        $request->user()->googleDriveToken()?->delete();
        return back()->with('success', 'Koneksi Google Drive telah diputus.');
    }

    private function makeClient(): Client
    {
        $client = new Client();
        $client->setAuthConfig(config('google.oauth_client_json'));
        $client->setRedirectUri(config('google.redirect_uri'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setIncludeGrantedScopes(true);
        $client->addScope(Drive::DRIVE);

        return $client;
    }
}
