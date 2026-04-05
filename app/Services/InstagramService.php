<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class InstagramService
{
    protected $accessToken;
    protected $apiUrl = 'https://graph.instagram.com/me/media';

    public function __construct()
    {
        $this->accessToken = Setting::getValue('instagram_access_token');
    }

    public function getLatestMedia($limit = 6)
    {
        if (!$this->accessToken) {
            return collect();
        }

        return Cache::remember('instagram_feed', 3600, function () use ($limit) {
            try {
                $response = Http::get($this->apiUrl, [
                    'fields' => 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp',
                    'access_token' => $this->accessToken,
                    'limit' => $limit
                ]);

                if ($response->successful()) {
                    return collect($response->json()['data']);
                }

                Log::error('Instagram API Error: ' . $response->body());
                return collect();
            } catch (\Exception $e) {
                Log::error('Instagram Service Error: ' . $e->getMessage());
                return collect();
            }
        });
    }

    public function isConnected()
    {
        return !empty($this->accessToken);
    }
}
