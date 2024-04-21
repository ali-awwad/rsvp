<?php

namespace App\Http\Resources;

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
            'uuid'=>$this->uuid,
            'title'=>$this->title,
            'description'=>$this->description,
            'location'=>$this->location,
            'parking'=>$this->parking,
            'parking_link'=>$this->parking_link,
            'start_date'=>Carbon::parse($this->start_date)->translatedFormat('l - F j - Y'),
            'start_time'=>Carbon::parse($this->start_date)->translatedFormat('g:i A'),
        ];
    }
}
