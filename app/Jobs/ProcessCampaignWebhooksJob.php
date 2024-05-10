<?php

namespace App\Jobs;

use App\Enums\HttpMethods;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Webhook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessCampaignWebhooksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Campaign $campaign,
        public Contact $contact
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // get the webhooks for the campaign
        $webhooks = $this->campaign->webhooks;

        // loop through the webhooks and send a request
        foreach ($webhooks as $webhook) {
            if (!$webhook instanceof Webhook) {
                continue;
            }
            if (!$webhook->is_active) {
                continue;
            }
            // send the request
            $client = Http::baseUrl($webhook->url);
            if ($webhook->bearer_token) {
                $client->withToken($webhook->bearer_token);
            }
            if ($webhook->headers) {
                $client->withHeaders(json_decode($webhook->headers, true));
            }
            $payload = collect([
                'campaign' => $this->campaign->withoutRelations()->toArray(),
                'contact' => $this->contact->toArray(),
                'pivot' => $this->contact->campaigns()->find($this->campaign->id)->pivot->toArray(),
            ] );
            if ($webhook->payload) {
                $payload = $payload->merge(json_decode($webhook->payload, true));
            }
            $client->withBody($payload->toJson());

            $response = $client->send($webhook->method->value, '/');
        }
    }
}
