<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $isUpdating = $this->isMethod('put') || $this->isMethod('patch');
        $userId = $this->route('user')?->id ?? $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255'],
            
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                $isUpdating ? Rule::unique('users', 'email')->ignore($userId) : 'unique:users,email'
            ],

            'password' => [
                $isUpdating ? 'nullable' : 'required', 
                'string', 
                'min:6', 
                'confirmed'
            ],

            'is_active' => ['required', 'boolean']
        ];
    }

    public function messages() {
        return [
            'name.required' => 'El nombre de usuario es requerido.',
            'email.required' => 'El correo es requerido.',
            'email.unique' => 'Ese correo ya esta en uso.',
            'password.required' => 'El password es requerido.',
            'password.min' => 'El password debe tener minimo 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }   
}
