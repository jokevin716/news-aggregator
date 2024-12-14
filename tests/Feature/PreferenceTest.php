<?php

namespace Tests\Feature;

use App\Models\Preference;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PreferenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_set_preferences()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/setPreferences', [
                'categories' => ['tech', 'news'],
                'sources' => ['NewsAPI', 'NYTimes'],
                'authors' => ['John Doe'],
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['categories', 'sources', 'authors']);
        $this->assertDatabaseHas('preferences', ['user_id' => $user->id]);
    }

    public function test_user_can_get_preferences()
    {
        $user = User::factory()->create();

        Preference::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/getPreferences');

        $response->assertStatus(200)
            ->assertJsonStructure(['categories', 'sources', 'authors']);
    }
}
