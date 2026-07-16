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
            'admin_id' => ['required', 'exists:users,id'],
            'branch_name'     => ['required', 'string', 'max:255'],
            'location' => ['required', 'string'],
            'is_active' => ['required', 'boolean']
        ];
    }

    public function messages() 
    {
        return [
            'admin_id.required' => "El usuario administrador es requerido.",
            'branch_name.required'     => "El nombre de la sucursal es requerida.",
            'branch_name.max'          => "El nombre es demaciado grande, debe ser de maximo 255 caracteres.",
            'location.required' => "La locacion de la sucursal es requerida.",
        ];
    }
}
