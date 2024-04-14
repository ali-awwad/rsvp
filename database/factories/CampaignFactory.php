<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'status'=>fake()->randomElement(['draft', 'scheduled', 'published', 'completed', 'cancelled']),
            'location' => fake()->address(),
            'description' => fake()->paragraph(),
            'start_date' => Carbon::parse(fake()->dateTimeBetween('+3 days', '+5 days'))->startOfHour(),
            'end_date' => Carbon::parse(fake()->dateTimeBetween('+7 days', '+10 days'))->startOfHour(),
            'parking' => fake()->sentence(),
            'parking_link' => fake()->url(),
        ];
    }
}
