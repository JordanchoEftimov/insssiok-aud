<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'event_date' => $this->event_date,
            'capacity' => $this->capacity,
            'location' => $this->location,
            'reservations' => $this->whenLoaded('reservations'),
        ];
    }
}
