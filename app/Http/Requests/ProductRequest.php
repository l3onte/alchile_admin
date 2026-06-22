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
            'name'              => 'required|string|max:255',
            'sku'               => 'required|string|unique:products,sku,' . ($this->product?->id ?? 'NULL'),
            'purchase_price'    => 'required|numeric|min:0',
            'sell_price'        => 'required|numeric|min:0',
            'id_category'       => 'required|exists:products_categories,id',
        ];
    }

    public function messages(): array 
    {
        return [
            'name.required'     => 'El nombre del producto es obligatorio.',
            'sku.unique'        => 'Este sku ya esta registrado.',
            'sell_price.min'    => 'El precio de venta no puede ser negativo.',
            'purchase_price.min' => 'El precio de compra no puede ser negativo.',
            'id_category.exists' => 'Esa categoria no existe.' 
        ];
    }
}
