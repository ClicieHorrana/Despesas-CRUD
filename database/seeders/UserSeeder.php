<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run(): void
    {
          // \App\Models\User::factory(10)->create();

        \App\Models\User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@dev.com',
            'password' => bcrypt('123'),
            'role' => 'admin'
        ]);

        \App\Models\User::query()->create([
            'name'=> 'User',
            'email'=> 'user@dev.com',
            'password'=> bcrypt('123'),
            'role'=> 'user'
        ]);
    }
}
