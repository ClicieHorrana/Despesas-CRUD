<?php

namespace App\Http\Requests;

use App\Policies\ExpensePolicy;
use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return app(ExpensePolicy::class)->store($this->user()) || app(ExpensePolicy::class)->update($this->user());
    }

    public function rules(): array
    {
        return [
            "description" => "required|string|max:191",
            "user_id" => "required|integer|exists:users,id",
            "amount" => "required|numeric|min:0",
            'date_expense' => "nullable|date|before_or_equal:now|date_format:Y-m-d"
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'A descrição da despesa é obrigatória.',
            'date_expense.required' => 'A data da despesa é obrigatória.',
            'date_expense.before_or_equal' => 'A data não pode ser no futuro.',
            'amount.required' => 'O valor da despesa é obrigatório.',
            'amount.min' => 'O valor da despesa não pode ser negativo.',
            'user_id' => 'O autor/responsável da despesa é obrigatório.',
        ];
    }
}
