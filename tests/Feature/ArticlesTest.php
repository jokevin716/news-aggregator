<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_get_articles_with_filters()
    {
        $user = User::factory()->create();

        Article::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/getFilteredArticles?keyword=sample&category=tech');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links']);
    }

    public function test_get_article_data_by_id()
    {
        // Setup: Create a user and an article
        $user = User::factory()->create();

        $article = Article::create([
            'title' => 'Test Article',
            'author' => 'John Doe',
            'description' => 'This is a test description.',
            'content' => 'This is test content.',
            'categories' => 'news,tech',
            'source' => 'NewsAPI',
            'url' => 'https://example.com/article',
            'published_at' => now(),
            'keywords' => 'test,description,news,tech',
        ]);

        // Action: Retrieve the article by ID
        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/getArticleById/{$article->id}");

        // Assertions
        $response->assertStatus(200)
            ->assertJson([
                'id' => $article->id,
                'title' => 'Test Article',
                'author' => 'John Doe',
                'description' => 'This is a test description.',
                'content' => 'This is test content.',
                'categories' => 'news,tech',
                'source' => 'NewsAPI',
                'url' => 'https://example.com/article',
                'published_at' => $article->published_at->toISOString(),
                'keywords' => 'test,description,news,tech',
        ]);

        // Optional: Ensure the data was retrieved correctly
        $this->assertDatabaseHas('articles', ['id' => $article->id]);
    }
}
