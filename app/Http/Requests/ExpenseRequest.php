<?php

namespace App\Http\Requests;

use App\Models\Expense;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('store', Expense::class) || 
        (Gate::allows('update', $this->route('expense')) && $this->route('expenses'));
    }

    public function rules(): array
    {
        return [
            "description" => "required|string|max:191",
            "user_id" => "required|integer|exists:users,id",
            "amount" => "required|numeric|min:0",
            'expense_date' => "nullable|date|before_or_equal:now|date_format:Y-m-d"
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'A descrição da despesa é obrigatória.',
            'expense_date.required' => 'A data da despesa é obrigatória.',
            'expense_date.before_or_equal' => 'A data não pode ser no futuro.',
            'amount.required' => 'O valor da despesa é obrigatório.',
            'amount.min' => 'O valor da despesa não pode ser negativo.',
            'user_id' => 'O autor/responsável da despesa é obrigatório.',
        ];
    }
}
