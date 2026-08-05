<?php

namespace Tests\Feature\Api;

use App\Models\Guitar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuitarApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_lists_guitars_ordered_by_price(): void
    {
        Guitar::factory()->create(['name' => 'High', 'price' => 50000]);
        Guitar::factory()->create(['name' => 'Low', 'price' => 20000]);

        $response = $this->getJson('/api/guitars');

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.name', 'Low')
            ->assertJsonPath('data.1.name', 'High');
    }

    public function test_filters_guitars_by_level(): void
    {
        Guitar::factory()->create(['name' => 'Beginner Model', 'level' => 'beginner']);
        Guitar::factory()->create(['name' => 'Advanced Model', 'level' => 'advanced']);

        $response = $this->getJson('/api/guitars?level=beginner');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Beginner Model');
    }

    public function test_searches_guitars_by_keyword(): void
    {
        Guitar::factory()->create(['name' => 'FS820', 'brand' => 'YAMAHA']);
        Guitar::factory()->create(['name' => 'LX1', 'brand' => 'Martin']);

        $response = $this->getJson('/api/guitars?q=YAMAHA');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'FS820');
    }

    public function test_shows_guitar_by_id(): void
    {
        $guitar = Guitar::factory()->create(['name' => 'FG830']);

        $response = $this->getJson('/api/guitars/'.$guitar->id);

        $response->assertOk()
            ->assertJsonPath('data.name', 'FG830')
            ->assertJsonPath('data.id', $guitar->id);
    }
}
