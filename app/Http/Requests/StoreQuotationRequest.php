<?php

namespace App\Http\Requests;

use App\Rules\AgeLoadRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuotationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'age' => ['required', 'string', 'regex:/^\d+(,\d+)*$/', new AgeLoadRule],
            'currency_id' => ['required', 'string', Rule::exists('currencies', 'code')],
            'start_date' => ['required', 'date', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', 'after:start_date'],
        ];
    }

    /**
     * Get the custom validation messages for the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'start_date.date_format' => 'The start date must be a valid date in ISO 8601 format (YYYY-MM-DD).',
            'end_date.date_format' => 'The end date must be a valid date in ISO 8601 format (YYYY-MM-DD).',
        ];
    }
}
