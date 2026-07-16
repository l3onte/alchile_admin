<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MeasurementUnitRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'abbreviation' => ['required', 'string', 'max:4'],
            'is_active' => ['required', 'boolean']
        ];
    }

    public function messages() 
    {
        return [
            'name.required' => "El nombre de la unidad es requerida.",
            'abbreviation.required' => "La abreviacion de la unidad es requerida.",
            'abbreviation.max' => "La abreviacion debe tener maximo 4 caracteres."
        ];
    }
}
