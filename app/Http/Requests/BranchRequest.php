<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
          'admin_id'        => 'required',
          'name'            => 'required|string|max:255',
          'phone'           => 'required|string',
          'address'         => 'required|string'  
        ];
    }

    public function messages(): array 
    {
        return [
            'admin_id.required'      => 'Es requerido un gerente.',
            'name.required'          => 'El nombre de la sucursal es requerido.',
            'phone.required'         => 'El numero de telefono es requerido.',
            'address.required'       => 'La direccion de la sucursal es requerida.'
        ];
    }
}
