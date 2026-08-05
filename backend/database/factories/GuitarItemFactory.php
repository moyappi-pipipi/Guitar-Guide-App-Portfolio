<?php

namespace Database\Factories;

use App\Models\GuitarItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GuitarItem>
 */
class GuitarItemFactory extends Factory
{
    protected $model = GuitarItem::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'brand' => fake()->company(),
            'category' => fake()->randomElement(['pick', 'capo', 'tuner', 'string', 'strap']),
            'price' => fake()->numberBetween(100, 5000),
            'specs' => fake()->optional()->word(),
            'description' => fake()->sentence(12),
            'image_url' => 'https://example.com/item.jpg',
            'is_recommended' => false,
        ];
    }
}
