<?php

namespace App\Actions;

use App\Enums\Reply;
use App\Models\Campaign;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class StoreContactToCampaign
{
    public static function execute(Campaign $campaign, array $data): Contact
    {
        DB::beginTransaction();
        try {
            // Create Contact
            $contact = Contact::firstOrCreate(['email' => $data['email']], [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'company' => $data['company'],
                'mobile' => $data['mobile'],
                'country_code' => $data['country_code'],
            ]);
            // Attach Contact to Campaign
            $campaign->contacts()->syncWithoutDetaching([
                $contact->id => [
                    'notes' => $data['notes'],
                    'reply' => Reply::from($data['reply']),
                ]
            ]);
            DB::commit();
            return $contact;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
