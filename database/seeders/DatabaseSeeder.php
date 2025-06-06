<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            TipoMaquinariaSeeder::class,
            DisponibilidadSeeder::class,
            MaquinariaSeeder::class,
            ReseniaSeeder::class,
            ReseniaSeeder::class,
            ReservaSeeder::class,
            TarjetaSeeder::class
        ]);

    }
}
