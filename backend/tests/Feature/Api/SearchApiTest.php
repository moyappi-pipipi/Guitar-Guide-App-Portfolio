<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\Guitar;
use App\Models\GuitarItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_searches_across_articles_guitars_and_items(): void
    {
        Article::factory()->create([
            'title' => 'おすすめのピック',
            'excerpt' => 'ピックの選び方',
        ]);
        Article::factory()->create([
            'title' => 'コード表',
            'excerpt' => '基本コード',
        ]);
        Guitar::factory()->create(['name' => 'ピックガード付き', 'brand' => 'YAMAHA']);
        Guitar::factory()->create(['name' => 'FS820', 'brand' => 'YAMAHA']);
        GuitarItem::factory()->create(['name' => 'おすすめピック', 'category' => 'pick']);
        GuitarItem::factory()->create(['name' => 'Capo', 'category' => 'capo']);

        $response = $this->getJson('/api/search?q=ピック');

        $response->assertOk()
            ->assertJsonCount(1, 'data.articles')
            ->assertJsonCount(1, 'data.guitars')
            ->assertJsonCount(1, 'data.guitar_items');
    }

    public function test_returns_empty_results_for_blank_query(): void
    {
        Article::factory()->create();

        $response = $this->getJson('/api/search?q=');

        $response->assertOk()
            ->assertJsonCount(0, 'data.articles')
            ->assertJsonCount(0, 'data.guitars')
            ->assertJsonCount(0, 'data.guitar_items');
    }
}
