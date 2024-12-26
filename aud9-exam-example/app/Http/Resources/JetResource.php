<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'model' => $this->model,
            'capacity' => $this->capacity,
            'hourly_rate' => $this->hourly_rate,
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}
