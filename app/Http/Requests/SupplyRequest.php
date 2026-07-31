<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SupplyRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier_id'         => ['nullable', 'exists:suppliers,id'],
            'name'                => ['required', 'string', 'max:255'],
            'measurement_unit_id' => ['nullable', 'exists:measurement_units,id'],
            'status'              => ['boolean'],
        ];
    }
}
