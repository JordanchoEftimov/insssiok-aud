<?php

namespace App\Http\Resources\Invoice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'invoice_number' => $this->invoice_number,
            'client_name' => $this->client->full_name,
            'client_id' => $this->client->id,
            'created_at' => $this->created_at->toDateString(),
            'due_date' => $this->due_date,
            'status' => ucfirst($this->status),
            'status_value' => $this->status,
        ];
    }
}
