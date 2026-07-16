<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'contact_name' => ['required'],
            'name' => ['required', 'max:255'],
            'is_active' => ['required', 'boolean'],
            'phone' => ['nullable'],
            'email' => ['nullable']
        ];
    }

    public function messages() 
    {
        return [
            'contact_name.required' => 'El nombre de la persona a contactar es requerido.',
            'name.required' => 'El nombre del Proveedor es requerido.',
            'name.max' => 'El nombre del Proveedor debe tener maximo 255 caracteres.'
        ];
    }
}
