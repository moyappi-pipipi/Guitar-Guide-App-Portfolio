<?php

namespace Database\Factories;

use App\Models\Guitar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guitar>
 */
class GuitarFactory extends Factory
{
    protected $model = Guitar::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->bothify('Model-###'),
            'brand' => fake()->randomElement(['YAMAHA', 'Martin', 'Fender', 'Epiphone']),
            'price' => fake()->numberBetween(15000, 80000),
            'body_type' => fake()->randomElement(['dreadnought', 'concert', 'mini', 'classical']),
            'level' => fake()->randomElement(['beginner', 'intermediate', 'advanced']),
            'description' => fake()->sentence(16),
            'image_url' => 'https://example.com/guitar.jpg',
            'is_recommended' => false,
        ];
    }
}
