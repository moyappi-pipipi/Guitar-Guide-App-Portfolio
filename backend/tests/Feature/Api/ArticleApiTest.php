<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_lists_articles(): void
    {
        Article::factory()->create([
            'title' => '古い記事',
            'slug' => 'old-article',
            'published_at' => now()->subDays(2),
        ]);
        Article::factory()->create([
            'title' => '新しい記事',
            'slug' => 'new-article',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->getJson('/api/articles');

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.slug', 'new-article');
    }

    public function test_filters_articles_by_category(): void
    {
        Article::factory()->create(['category' => 'guitar', 'slug' => 'guitar-1']);
        Article::factory()->create(['category' => 'gear', 'slug' => 'gear-1']);

        $response = $this->getJson('/api/articles?category=guitar');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.slug', 'guitar-1');
    }

    public function test_searches_articles_by_keyword(): void
    {
        Article::factory()->create([
            'title' => 'おすすめのピック',
            'slug' => 'picks',
            'excerpt' => 'ピック紹介',
        ]);
        Article::factory()->create([
            'title' => 'コード表',
            'slug' => 'chords',
            'excerpt' => '基本コード',
        ]);

        $response = $this->getJson('/api/articles?q=ピック');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.slug', 'picks');
    }

    public function test_shows_article_by_slug(): void
    {
        Article::factory()->create([
            'title' => '詳細記事',
            'slug' => 'detail-article',
        ]);

        $response = $this->getJson('/api/articles/detail-article');

        $response->assertOk()
            ->assertJsonPath('data.title', '詳細記事')
            ->assertJsonPath('data.slug', 'detail-article');
    }

    public function test_returns_not_found_for_unknown_slug(): void
    {
        $this->getJson('/api/articles/missing')->assertNotFound();
    }
}
