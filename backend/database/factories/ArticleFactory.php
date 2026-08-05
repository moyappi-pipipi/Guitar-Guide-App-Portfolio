<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => fake()->unique()->slug(),
            'category' => fake()->randomElement(['beginner', 'guitar', 'gear', 'news']),
            'excerpt' => fake()->sentence(12),
            'body' => fake()->paragraphs(2, true),
            'thumbnail_url' => 'https://example.com/thumb.jpg',
            'is_featured' => false,
            'published_at' => now(),
        ];
    }
}
