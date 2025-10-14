<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'variation_id' => 'nullable|integer|exists:product_variations,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'O ID do produto é obrigatório.',
            'product_id.integer' => 'O ID do produto deve ser um número inteiro.',
            'product_id.exists' => 'O produto selecionado não existe.',
            'variation_id.integer' => 'O ID da variação deve ser um número inteiro.',
            'variation_id.exists' => 'A variação selecionada não existe.',
            'quantity.required' => 'A quantidade é obrigatória.',
            'quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'quantity.min' => 'A quantidade mínima é 1.',
        ];
    }
}
