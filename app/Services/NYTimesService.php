<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NYTimesService
{
    public function fetchArticles($queryParams = [])
    {
        $url = config('services.nytimes.base_url');
        $response = Http::get($url, array_merge($queryParams, [
            'api-key' => config('services.nytimes.key'),
        ]));

        return $response->successful() ? $response->json()['response']['docs'] ?? [] : [];
    }
}
