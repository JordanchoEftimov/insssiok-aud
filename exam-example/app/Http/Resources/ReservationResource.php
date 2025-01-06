<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_name' => $this->user_name,
            'reservation_date' => $this->reservation_date,
            'duration_hours' => $this->duration_hours,
            'yacht' => new YachtResource($this->whenLoaded('yacht')),
        ];
    }
}
