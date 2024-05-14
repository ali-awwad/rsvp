<?php

namespace App\Http\Resources;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'status' => $this->status,
            'description' => $this->description,
            'logo' => $this->getFirstMediaUrl('logo'),
            'background' => $this->getFirstMediaUrl('background', 'webpbg'),
            'sponsors' => $this->getMedia('sponsors')->map(fn ($media) => $media->getFullUrl()),
            'location' => $this->location,
            'parking' => $this->parking,
            'parking_link' => $this->parking_link,
            'start_date' => Carbon::parse($this->start_date)->translatedFormat('l - F j - Y'),
            'start_time' => Carbon::parse($this->start_date)->translatedFormat('g:i A'),
            'end_date' => Carbon::parse($this->end_date)->translatedFormat('l - F j - Y'),
            'end_time' => Carbon::parse($this->end_date)->translatedFormat('g:i A'),
            // start date - end date
            'date_range' => Carbon::parse($this->start_date)->translatedFormat('F j - Y') . ' - ' . Carbon::parse($this->end_date)->translatedFormat('F j - Y'),
            // start time - end time
            'time_range' => Carbon::parse($this->start_date)->translatedFormat('g:i A') . ' - ' . Carbon::parse($this->end_date)->translatedFormat('g:i A'),
        ];
    }
}
