<?php

namespace App\Models;

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
     * Mutator for mobile to be with country code, remove spaces and leading zeros
     */
    public function mobile(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                // remove leading zeros
                $value = ltrim($value, '0');
                // remove all non-numeric characters
                $value = preg_replace('/\D/', '', $value);
                return $value;
            }
        );
    }

    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class);
    }
}
