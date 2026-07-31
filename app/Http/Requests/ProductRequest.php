<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => ['required'],
            'is_reventa' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
            'measurement_unit_id' => ['nullable']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "El nombre del producto es requerido."
        ];
    }
}
