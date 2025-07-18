<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; // Importar Carbon

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Principal
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@maquinarias.com',
            'dni' => '12345678',
            'password' => Hash::make('password123'),
            // 'edad' => 35,
            'fecha_nacimiento' => Carbon::now()->subYears(35)->format('Y-m-d'),
            'telefono' => '+54 11 1234-5678',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Empleado
        User::create([
            'name' => 'Juan Empleado',
            'email' => 'empleado@maquinarias.com',
            'dni' => '87654321',
            'password' => Hash::make('password123'),
            // 'edad' => 28,
            'fecha_nacimiento' => Carbon::now()->subYears(28)->format('Y-m-d'),
            'telefono' => '+54 11 8765-4321',
            'role' => 'employee',
            'email_verified_at' => now(),
        ]);

        // Usuario Cliente
        User::create([
            'name' => 'María Cliente',
            'email' => 'cliente@maquinarias.com',
            'dni' => '55556666',
            'password' => Hash::make('password123'),
            // 'edad' => 42,
            'fecha_nacimiento' => Carbon::now()->subYears(42)->format('Y-m-d'),
            'telefono' => '+54 11 5555-6666',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Lauta',
            'email' => 'mastrangelolautaro19@gmail.com',
            'dni' => '52663616',
            'password' => Hash::make('password123'),
            // 'edad' => 42,
            'fecha_nacimiento' => Carbon::now()->subYears(25)->format('Y-m-d'),
            'telefono' => '+54 11 5555-6666',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Tu usuario personal
        User::create([
            'name' => 'Fraanj',
            'email' => 'fraanj@test.com',
            'dni' => '25592204',
            'password' => Hash::make('123456'),
            // 'edad' => 25,
            'fecha_nacimiento' => Carbon::now()->subYears(25)->format('Y-m-d'), // Asumiendo que tu edad actual es 25
            'telefono' => '+54 221 592-2204',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
