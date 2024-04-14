<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Campaign extends Model
{
    use HasFactory, Uuidable;

    protected $fillable = [
        // 'uuid',
        'title',
        'status',
        'location',
        'description',
        'start_date',
        'end_date',
        'parking',
        'parking_link',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status'=> Status::class,
    ];

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class);
    }
}
