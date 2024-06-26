<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Ali',
            'email' => 'a.awwad@outlook.com',
            'role' => Role::ADMIN->value,
        ]);
        User::factory(2)->create();

        $campaigns = \App\Models\Campaign::factory(2)->create();
        \App\Models\Contact::factory(2)->create();

        foreach ($campaigns as $campaign) {
            $contacts = \App\Models\Contact::inRandomOrder()->take(rand(5, 10))->pluck('id');
            $contacts = $contacts->mapWithKeys(function ($contact) use($campaign) {
                return [
                    $contact => [
                        'reply' => collect(\App\Enums\Reply::cases())->random()->value,
                        'notes' => fake()->sentence(),
                        'visited_at' => rand(0, 1) ? fake()->dateTimeBetween($campaign->start_date, $campaign->end_date) : null,
                    ]
                ];
            });
            $campaign->contacts()->attach($contacts);

            $campaign->addMediaFromUrl('https://source.unsplash.com/random/1920x1080')
                ->toMediaCollection('background');
            $campaign->addMediaFromUrl('https://source.unsplash.com/random/400x400')
                ->toMediaCollection('logo');


            for ($i=0; $i < rand(1, 5); $i++) {
                $campaign->addMediaFromUrl('https://source.unsplash.com/random/200x200')
                ->toMediaCollection('sponsors');
            }

            \App\Models\Webhook::factory(rand(1, 3))->create([
                'campaign_id' => $campaign->id,
            ]);

        }
    }
}
