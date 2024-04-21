<?php

namespace Database\Factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    public function definition(): array
    {
        $statuses = collect(Status::cases())->pluck('value')->toArray();
        return [
            'title' => fake()->sentence(),
            'status'=>fake()->randomElement($statuses),
            'location' => fake()->address(),
            'description' => fake()->paragraph(),
            'publish_date' => Carbon::parse(fake()->dateTimeBetween('0 days', '+1 days'))->startOfHour(),
            'start_date' => Carbon::parse(fake()->dateTimeBetween('+3 days', '+5 days'))->startOfHour(),
            'end_date' => Carbon::parse(fake()->dateTimeBetween('+7 days', '+10 days'))->startOfHour(),
            'parking' => fake()->sentence(),
            'parking_link' => fake()->url(),
        ];
    }
}
