<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Preference>
 */
class PreferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'categories' => json_encode($this->faker->randomElements(['tech', 'news', 'finance', 'sports'], 2)),
            'sources' => json_encode($this->faker->randomElements(['NewsAPI', 'NYTimes', 'Guardian'], 2)),
            'authors' => json_encode($this->faker->randomElements(['Author 1', 'Author 2', 'Author 3'], 2)),
        ];
    }
}
