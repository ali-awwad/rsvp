<?php

namespace App\Listeners;

use App\Events\ContactAddedToCampaign;
use App\Jobs\ProcessCampaignWebhooksJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RunCampaignWebhooks
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ContactAddedToCampaign $event): void
    {
        // dispatch a job to run the webhooks
        ProcessCampaignWebhooksJob::dispatch($event->campaign, $event->contact);
    }
}
