<?php

namespace App\Providers;

use App\Models\Expense;
use App\Models\User;
use App\Policies\ExpensePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Expense::class => ExpensePolicy::class,
    ];

    
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('access-admin', function (User $user) {
            return $user->role === 'admin';
        });
        
    }
}
