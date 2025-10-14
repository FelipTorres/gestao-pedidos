<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'key.required' => 'A chave do item é obrigatória.',
            'key.string' => 'A chave do item deve ser uma string.',
            'quantity.required' => 'A quantidade é obrigatória.',
            'quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'quantity.min' => 'A quantidade deve ser pelo menos 1.',
        ];
    }
}
