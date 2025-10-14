<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cep' => 'required|string',
            'logradouro' => 'required|string',
            'numero' => 'required|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'uf' => 'required|string',
            'complemento' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'cep.required' => 'O campo CEP é obrigatório.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'uf.required' => 'O campo UF é obrigatório.',
        ];
    }
}
