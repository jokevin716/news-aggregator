<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NewsAPIService;
use App\Services\NYTimesService;
use App\Services\GuardianService;
use App\Models\Article;

class FetchArticlesCommand extends Command
{
    protected $signature = 'fetch:articles';
    protected $description = 'Fetch articles from NewsAPI, NYTimes, and The Guardian';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(
        NewsAPIService $newsAPIService,
        NYTimesService $nytService,
        GuardianService $guardianService
    ) {
        $this->info('Fetching from NewsAPI...');
        $this->storeArticles($newsAPIService->fetchArticles([
            'language' => 'en',
            'pageSize' => 100,
        ]));

        $this->info('Fetching from NYTimes...');
        $this->storeArticles($nytService->fetchArticles([
            'sort' => 'newest',
        ]));

        $this->info('Fetching from The Guardian...');
        $this->storeArticles($guardianService->fetchArticles([
            'page-size' => 50,
        ]));

        $this->info('Articles fetched and stored successfully.');
    }

    private function storeArticles(array $articles)
    {
        foreach ($articles as $article) {
            // Transform each article into your DB format
            Article::updateOrCreate(
                [
                    'url' => $this->extractUrl($article)
                ],
                [
                    'title' => $this->extractTitle($article),
                    'description' => $this->extractDescription($article),
                    'content' => $this->extractContent($article),
                    'source' => $this->extractSource($article),
                    'url' => $this->extractUrl($article),
                    'published_at' => $this->extractPublishedAt($article),
                    'keywords' => $this->extractKeywords($article),
                    'categories' => $this->extractCategories($article),
                ]
            );
        }
    }

    private function extractTitle($article)
    {
        return $article['title'] ?? $article['headline']['main'] ?? $article['webTitle'] ?? 'No Title';
    }

    private function extractDescription($article)
    {
        return $article['description'] ?? $article['abstract'] ?? 'No Description';
    }

    private function extractContent($article)
    {
        return $article['content'] ?? $article['snippet'] ?? '';
    }

    private function extractSource($article)
    {
        return $article['source']['name'] ?? $article['source'] ?? 'Unknown';
    }

    private function extractUrl($article)
    {
        return $article['url'] ?? $article['web_url'] ?? $article['webUrl'] ?? null;
    }

    private function extractPublishedAt($article)
    {
        return $article['publishedAt'] ?? $article['pub_date'] ?? $article['webPublicationDate'] ?? null;
    }

    private function extractKeywords($article)
    {
        $content = $this->extractContent($article);
        return collect(explode(' ', $content))->take(10)->join(', ');
    }

    private function extractCategories($article)
    {
        // Example handling for each API
        if (isset($article['source']['category'])) {
            return $article['source']['category'];
        }

        if (isset($article['section_name'])) {
            return $article['section_name']; // NYTimes section
        }

        if (isset($article['pillarName'])) {
            return $article['pillarName']; // The Guardian section
        }

        return 'Uncategorized'; // Default if no category exists
    }
}
