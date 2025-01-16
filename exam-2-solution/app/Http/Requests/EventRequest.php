<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_date' => ['required', 'date', 'after:today'],
            'capacity' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'max:255'],
            'description' => ['required', 'max:65535'],
            'location' => ['required', 'max:255'],
        ];
    }
}
