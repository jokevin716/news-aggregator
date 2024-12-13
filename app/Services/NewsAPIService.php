<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsAPIService
{
    public function fetchArticles($queryParams = [])
    {
        $url = config('services.newsapi.base_url') . '/everything';
        $response = Http::get($url, array_merge($queryParams, [
            'apiKey' => config('services.newsapi.key'),
        ]));

        return $response->successful() ? $response->json()['articles'] ?? [] : [];
    }
}
