<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Role::factory()->create([
            'name' => 'Admin',
            'description' => 'Total access',
            'role_number' => 1
        ]);
        \App\Models\Role::factory()->create([
            'name' => 'User',
            'description' => 'mediun access',
            'role_number' => 2
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Alvaro Japa Salazar',
            'email' => 'alvaro@gmail.com',
            'password' => Hash::make('dragonball'),
            'phone' => '993340954',
            'status' => true,
            'role_id' => 1
        ]);
     
    }
}
