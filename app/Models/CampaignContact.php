<?php

namespace App\Models;

use App\Enums\Reply;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CampaignContact extends Pivot
{
    protected $casts = [
        'visited_at'=> 'datetime',
        'reply'=> Reply::class
    ];
}
