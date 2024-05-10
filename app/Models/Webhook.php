<?php

namespace App\Models;

use App\Enums\HttpMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Webhook extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'is_active',
        'headers',
        'method',
        'payload',
        'bearer_token',
        'campaign_id',
    ];

    protected $casts = [
        'method' => HttpMethods::class,
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
