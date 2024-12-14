<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'content' => $this->faker->text,
            'source' => $this->faker->randomElement(['NewsAPI', 'NYTimes', 'Guardian']),
            'categories' => $this->faker->randomElement(['tech,news', 'business,finance']),
            'url' => $this->faker->url,
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'keywords' => $this->faker->randomElement(['tech,news', 'business,finance']),
        ];
    }
}
