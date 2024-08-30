<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => fake()->randomFloat($nbMaxDecimals = null, $min = 0, $max = 400),
            'expense_date' => now()->format('Y-m-d H:i:s'),
            'description' => fake()->randomElement(['Materiais de limpeza', 'Acessórios Eletrônicos', 'Lanche para Reuniões', 'Combustível', 'Papelaria'])
        ];
    }
}
