<?php

namespace Tests\Unit;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_created_contact_has_plus(): void
    {
        $contact = Contact::create([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->email(),
            'company' => fake()->company(),
            'mobile' => '0' . random_int(971551778639, 971551778999),
        ]);
        echo $contact->mobile;
        $this->assertStringContainsString('+971', $contact->mobile);
    }
}
