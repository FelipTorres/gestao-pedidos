<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'variations' => 'nullable|array',
            'variations.*.name' => 'required_with:variations|string|max:255',
            'variations.*.stock' => 'required_with:variations|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'price.required' => 'O preço do produto é obrigatório.',
            'variations.*.name.required_with' => 'O nome da variação é obrigatório quando as variações são fornecidas.',
            'variations.*.stock.required_with' => 'O estoque da variação é obrigatório quando as variações são fornecidas.',
        ];
    }
}
