<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('clients')->ignore($this->client->id),
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('clients')->ignore($this->client->id),
            ],
            'address' => 'required|string',
        ];
    }
}
