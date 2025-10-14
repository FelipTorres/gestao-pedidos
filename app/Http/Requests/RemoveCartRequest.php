<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemoveCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'key.required' => 'A chave do item é obrigatória.',
            'key.string' => 'A chave do item deve ser uma string.',
        ];
    }
}
