<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_name' => ['required', 'string', 'max:255'],
            'reservation_date' => ['required', 'date', 'after:today'],
            'duration_hours' => ['required', 'integer', 'min:1'],
            'yacht_id' => ['required', 'exists:yachts,id'],
        ];
    }
}
