<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reservas')->insert([
            [
                'user_id' => 1,
                'maquina_id' => 1,
                'fecha_inicio' => '2025-06-01',
                'fecha_fin' => '2025-06-05',
                'monto_total' => 1500.00,
                'fecha_reserva' => now(),
            ],
            [
                'user_id' => 1,
                'maquina_id' => 2,
                'fecha_inicio' => '2025-06-10',
                'fecha_fin' => '2025-06-12',
                'monto_total' => 800.00,
                'fecha_reserva' => now(),
            ]
        ]);
    }
}
