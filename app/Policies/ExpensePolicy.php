<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expense;

class ExpensePolicy
{
    public function store(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Expense $expense): bool
    {
        return $user->role === 'admin' || $user->id === $expense->user_id;
    }


    public function delete(User $user, Expense $expense): bool
    {
        return $user->role === 'admin' || $user->id === $expense->user_id;
    }
}
