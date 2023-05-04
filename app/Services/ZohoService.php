<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class ZohoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://www.zohoapis.com',
            'timeout'  => 10.0,
        ]);
    }

    public function getAccessToken()
    {
        $accessToken = Cache::get('zoho_access_token');

        if (!$accessToken) {
            $clientId = config('services.zoho.client_id');
            $clientSecret = config('services.zoho.client_secret');
            $refreshToken = config('services.zoho.refresh_token');

            $response = $this->client->post('/oauth/v2/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'refresh_token' => $refreshToken,
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $accessToken = $data['access_token'];
            $expiresIn = $data['expires_in'];
            $expiresAt = now()->addSeconds($expiresIn);

            Cache::put('zoho_access_token', $accessToken, $expiresAt);
            Cache::put('zoho_access_token_expires_at', $expiresAt, $expiresAt);
        }

        return $accessToken;
    }

    public function createDeal($dealData)
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->post('/crm/v2/Deals', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $dealData,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function createAccount($accountData)
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->post('/crm/v2/Accounts', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $accountData,
        ]);

        return json_decode($response->getBody(), true);
    }
}

?>
