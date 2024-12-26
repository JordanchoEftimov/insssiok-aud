<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'reviewer_name' => $this->reviewer_name,
            'text' => $this->text,
            'rating' => $this->rating,
            'status' => $this->status,
            'jet' => new JetResource($this->whenLoaded('jet')),
        ];
    }
}
