<?php

namespace App\Http\Requests\Invoice;

use App\Enums\InvoiceStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'invoice_number' => [
                'required',
                'string',
                Rule::unique('invoices', 'invoice_number')->ignore($this->invoice),
            ],
            'amount' => 'required|integer|min:0',
            'due_date' => 'required|date|after_or_equal:date',
            'status' => [
                'required',
                Rule::in(InvoiceStatusEnum::cases()),
            ],
            'client_id' => [
                'required',
                Rule::exists('clients', 'id'),
            ],
        ];
    }
}
