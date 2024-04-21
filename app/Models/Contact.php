<?php

namespace App\Models;

use App\Helpers\ContactHelper;
use App\Traits\Uuidable;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contact extends Model implements HasName
{
    use HasFactory, Uuidable;

    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'email',
        'mobile',
        'country_code',
    ];

    public function getFilamentName(): string
    {
        return $this->fullName;
    }

    /**
     * Fullname accessor
     */
    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}"
        );
    }

    /**
     * Mutator for mobile, remove spaces and leading zeros
     */
    public function mobile(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ContactHelper::correctMobile($value),
        );
    }

    public function internationalMobile(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->country_code . $this->mobile,
        );
    }

    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class)->using(CampaignContact::class)->withPivot(['reply', 'notes']);
    }
}
