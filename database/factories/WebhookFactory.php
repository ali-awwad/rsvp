<?php

namespace Database\Factories;

use App\Enums\HttpMethods;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Webhook>
 */
class WebhookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'url' => fake()->url(),
            'is_active' => fake()->boolean(),
            'headers' => json_encode([
                'X-Api-Key' => fake()->sha1(),
                'name' => fake()->sentence(),
            ]),
            'method' => collect(HttpMethods::cases())->pluck('value')->random(),
        ];
    }
}
