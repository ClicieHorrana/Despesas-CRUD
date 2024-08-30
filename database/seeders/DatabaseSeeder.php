<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        /**
        Para rodar o expense , é preciso descomentar a linha no <div class="env">
        APP_ENV=seeding
        e comentar a linha abaixo . Somente para a seeder.
        APP_ENV=local */
        
        // $this->call(ExpenseSeeder::class);
        $this->call(UserSeeder::class);
    }
}
