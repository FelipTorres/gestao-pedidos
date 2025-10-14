<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:50',
            'discount' => 'required|min:1|max:100',
            'min_value' => 'required|min:0',
            'validity' => 'required|date|after_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'O código do cupom é obrigatório.',
            'code.string' => 'O código do cupom deve ser uma string.',
            'code.max' => 'O código do cupom não pode ter mais de 50 caracteres.',
            'discount.required' => 'O desconto é obrigatório.',
            'discount.min' => 'O desconto deve ser pelo menos 1%.',
            'discount.max' => 'O desconto não pode ser maior que 100%.',
            'min_value.required' => 'O valor mínimo é obrigatório.',
            'min_value.min' => 'O valor mínimo não pode ser negativo.',
            'validity.required' => 'A validade é obrigatória.',
            'validity.date' => 'A validade deve ser uma data válida.',
            'validity.after_or_equal' => 'A validade deve ser hoje ou uma data futura.',
        ];
    }
}
