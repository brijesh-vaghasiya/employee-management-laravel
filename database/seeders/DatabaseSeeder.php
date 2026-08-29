<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::updateOrCreate(
            ['email' => 'admin@company.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create ASC User
        User::updateOrCreate(
            ['email' => 'asc@company.com'],
            [
                'name' => 'ASC Manager',
                'password' => Hash::make('password'),
                'role' => 'asc',
            ]
        );

        // Create initial Employee
        User::updateOrCreate(
            ['email' => 'employee@company.com'],
            [
                'name' => 'John Employee',
                'password' => Hash::make('password'),
                'role' => 'employee',
            ]
        );
    }
}
