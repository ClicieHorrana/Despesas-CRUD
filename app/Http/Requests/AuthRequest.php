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
            'name' =>'required|string|max: 100',
            'email' => 'required|email|max: 255',
            'password' => 'required|string|min: 3',
            'role' => 'nullable|string' ,
        ];
    }
    public function messages(): array
    {
        return [
            'name|required' => 'O nome é obrigatório',
            'email|required'=> 'Email é obrigatório',
            'password|required' => 'Senha é obrigatório',
        ];
    }
}
