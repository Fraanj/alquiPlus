<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisponibilidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('disponibilidades')->insert([
            ['nombre' => 'Disponible'],
            ['nombre' => 'NoDisponible'],
            ['nombre' => 'EsperandoEntrega'],
        ]);
    }
}
