<?php

namespace App\Filament\Resources\CampaignResource\Widgets;

use App\Models\Campaign;
use Filament\Widgets\Widget;
use Livewire\Attributes\Computed;

class CreateCampaign extends Widget
{
    protected static string $view = 'filament.resources.campaign-resource.widgets.create-campaign';

    #[Computed]
    public function campaignsByStatus()
    {
        return Campaign::select(['id','status'])->get()->groupBy('status')->sortKeys();
    }

    public function __construct()
    {

    }
}
