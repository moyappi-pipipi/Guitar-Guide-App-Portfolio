<?php

namespace Tests\Feature\Api;

use App\Models\GuitarItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuitarItemApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_lists_guitar_items(): void
    {
        GuitarItem::factory()->count(2)->create();

        $response = $this->getJson('/api/guitar-items');

        $response->assertOk()->assertJsonCount(2, 'data');
    }

    public function test_filters_items_by_category(): void
    {
        GuitarItem::factory()->create(['name' => 'Tortex', 'category' => 'pick']);
        GuitarItem::factory()->create(['name' => 'Quick Capo', 'category' => 'capo']);

        $response = $this->getJson('/api/guitar-items?category=pick');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Tortex');
    }

    public function test_shows_guitar_item_by_id(): void
    {
        $item = GuitarItem::factory()->create(['name' => 'SNARK Tuner']);

        $response = $this->getJson('/api/guitar-items/'.$item->id);

        $response->assertOk()
            ->assertJsonPath('data.name', 'SNARK Tuner')
            ->assertJsonPath('data.id', $item->id);
    }
}
