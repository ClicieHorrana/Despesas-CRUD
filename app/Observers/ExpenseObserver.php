<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\User;
use App\Notifications\ExpenseCreatedNotification;
use Illuminate\Support\Facades\Log;

class ExpenseObserver
{
    public function created(Expense $expense): void
    {
     
        if (env('APP_ENV') !== 'seeding') {
            Log::info('Usuário autenticado: ' . auth()->user()->email);
            $user = User::findOrFail(auth()->user()->id);
            $user->notify(new ExpenseCreatedNotification($expense));
        }    

    }
}
