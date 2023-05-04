<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ZohoTokenService
{
    public function getAccessToken()
    {
        $accessToken = Session::get('zoho_access_token');

        if (!$accessToken) {
            $accessToken = $this->refreshAccessToken();
        }

        return $accessToken;
    }

    public function refreshAccessToken()
    {
        $refreshToken = Session::get('zoho_refresh_token');

        $response = Http::asForm()->post('https://accounts.zoho.com/oauth/v2/token', [
            'refresh_token' => $refreshToken,
            'client_id' => config('services.zoho.client_id'),
            'client_secret' => config('services.zoho.client_secret'),
            'redirect_uri' => config('services.zoho.redirect'),
            'grant_type' => 'refresh_token'
        ]);

        $responseBody = $response->json();

        if (!isset($responseBody['access_token'])) {
            throw new \Exception('Access token not set.');
        }

        $accessToken = $responseBody['access_token'];

        Session::put('zoho_access_token', $accessToken);

        return $accessToken;
    }
}

?>