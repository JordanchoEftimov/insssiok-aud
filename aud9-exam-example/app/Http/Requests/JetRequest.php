<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1', 'max:65535'],
            'hourly_rate' => ['required', 'integer', 'min:1', 'max:65535'],
        ];
    }
}
