<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GuardianService
{
    public function fetchArticles($queryParams = [])
    {
        $url = config('services.guardian.base_url');
        $response = Http::get($url, array_merge($queryParams, [
            'api-key' => config('services.guardian.key'),
        ]));

        return $response->successful() ? $response->json()['response']['results'] ?? [] : [];
    }
}
