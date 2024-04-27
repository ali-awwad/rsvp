<?php

namespace App\Models;

use App\Enums\ImageMimeTypes;
use App\Enums\Status;
use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\Conversions\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Campaign extends Model implements HasMedia
{
    use HasFactory, Uuidable, InteractsWithMedia;

    protected $fillable = [
        // 'uuid',
        'title',
        'status',
        'location',
        'description',
        'publish_date',
        'start_date',
        'end_date',
        'parking',
        'parking_link',
    ];

    protected $casts = [
        'publish_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => Status::class,
    ];

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class)->using(CampaignContact::class)->withPivot(['reply', 'notes']);
    }

    public function registerMediaCollections(): void
    {
        $acceptedMimeTypes = ImageMimeTypes::values();

        $this->addMediaCollection('background')
        ->acceptsMimeTypes($acceptedMimeTypes)
        ->singleFile();

        $this->addMediaCollection('logo')
        ->acceptsMimeTypes($acceptedMimeTypes)
        ->singleFile();

        $this->addMediaCollection('sponsors')
        ->acceptsMimeTypes($acceptedMimeTypes)
        ->onlyKeepLatest(6);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->performOnCollections('background', 'logo')
            ->width(100)
            ->height(100);

        $this->addMediaConversion('webpbg')
            ->performOnCollections('background')
            // ->format(Manipulations::FORMAT_WEBP);
            ->keepOriginalImageFormat();
    }
}
