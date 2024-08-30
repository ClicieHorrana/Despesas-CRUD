<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'email' => 'required|email|max: 255',
            'password' => 'required|password|max: 255',
        ];
    }
    public function messages(): array
    {
        return [
            'email|required'=> 'Email é obrigatório',
            'password|required' => 'Senha é obrigatóri',
        ];
    }
}
