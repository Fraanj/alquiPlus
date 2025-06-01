<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Crear Admin
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@maquinarias.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Crear Empleado
        User::create([
            'name' => 'Juan Empleado',
            'email' => 'empleado@maquinarias.com',
            'password' => Hash::make('password123'),
            'role' => 'employee',
            'email_verified_at' => now(),
        ]);

        // Crear Usuario normal
        User::create([
            'name' => 'María Cliente',
            'email' => 'cliente@maquinarias.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Crear tu usuario personal (admin)
        User::create([
            'name' => 'Fraanj',
            'email' => 'fraanj@test.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
