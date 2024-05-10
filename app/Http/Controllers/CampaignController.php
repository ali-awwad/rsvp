<?php

namespace App\Http\Controllers;

use App\Actions\StoreContactToCampaign;
use App\Enums\Reply;
use App\Events\ContactAddedToCampaign;
use App\Helpers\ContactHelper;
use App\Http\Requests\StoreContactToCampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CampaignController extends Controller
{
    public function store(StoreContactToCampaignRequest $request, Campaign $campaign)
    {
        // Gate::authorize('update', $campaign); // TODO

        $contact = StoreContactToCampaign::execute($campaign, $request->validated());

        // Fire an event
        event(new ContactAddedToCampaign($campaign, $contact));

        return Redirect::route('campaigns.show', $campaign->uuid)->with('success', 'Thank you for accepting our invitation');
    }

    public function show(Request $request, Campaign $campaign)
    {
        Gate::authorize('view', $campaign); // TODO
        $replies = collect(Reply::cases())->map(function ($reply) {
            return [
                'value' => $reply->value,
                'label' => $reply->getLabel(),
                'icon' => $reply->getIcon(),
                'color' => $reply->getColor(),
            ];
        });

        return Inertia::render('Campaigns/Show', [
            'campaign' => CampaignResource::make($campaign),
            'replies' => $replies,
            'country_codes'=> ContactHelper::countryCodeList('AE')
        ]);
    }
}
