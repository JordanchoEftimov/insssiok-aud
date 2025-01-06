<?php

namespace App\Http\Requests;

use App\Enums\YachtType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class YachtRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::enum(YachtType::class)],
            'capacity' => ['required', 'integer', 'min:1'],
            'hourly_rate' => ['required', 'integer', 'min:1'],
        ];
    }
}
