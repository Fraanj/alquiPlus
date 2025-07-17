<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reservas')->insert([
            // Reservas originales
            [
                'user_id' => 1,
                'maquina_id' => 1,
                'fecha_inicio' => '2025-06-01',
                'fecha_fin' => '2025-06-05',
                'monto_total' => 1500.00,
                'fecha_reserva' => '2025-06-01 00:00:00',
                'estado' => 'pendiente',
            ],
            [
                'user_id' => 1,
                'maquina_id' => 2,
                'fecha_inicio' => '2025-06-10',
                'fecha_fin' => '2025-06-12',
                'monto_total' => 800.00,
                'fecha_reserva' => '2025-06-10 00:00:00',
                'estado' => 'pendiente',
            ],

            // Reservas para casos límite (user_id = 3)
            [
                'user_id' => 3,
                'maquina_id' => 1,
                'fecha_inicio' => '2025-07-07',
                'fecha_fin' => '2025-07-14',
                'monto_total' => 2100.00,
                'fecha_reserva' => '2025-07-07 00:00:00',
                'estado' => 'completada',
            ],
            [
                'user_id' => 3,
                'maquina_id' => 2,
                'fecha_inicio' => '2025-07-15',
                'fecha_fin' => '2025-07-19',
                'monto_total' => 1200.00,
                'fecha_reserva' => '2025-07-15 00:00:00',
                'estado' => 'confirmada',
            ],
            [
                'user_id' => 3,
                'maquina_id' => 3,
                'fecha_inicio' => '2025-07-20',
                'fecha_fin' => '2025-07-23',
                'monto_total' => 950.00,
                'fecha_reserva' => '2025-07-20 00:00:00',
                'estado' => 'pendiente',
            ],

            // 10 NUEVAS RESERVAS agrupadas por días para mejores estadísticas

            // 4 RESERVAS EN 2025-06-20 (día pico)
            [
                'user_id' => 1,
                'maquina_id' => 1,
                'fecha_inicio' => '2025-06-20',
                'fecha_fin' => '2025-06-22',
                'monto_total' => 1800.00,
                'fecha_reserva' => '2025-06-20 09:30:00',
                'estado' => 'completada',
            ],
            [
                'user_id' => 2,
                'maquina_id' => 2,
                'fecha_inicio' => '2025-06-20',
                'fecha_fin' => '2025-06-21',
                'monto_total' => 750.00,
                'fecha_reserva' => '2025-06-20 14:15:00',
                'estado' => 'completada',
            ],
            [
                'user_id' => 3,
                'maquina_id' => 3,
                'fecha_inicio' => '2025-06-20',
                'fecha_fin' => '2025-06-23',
                'monto_total' => 900.00,
                'fecha_reserva' => '2025-06-20 11:45:00',
                'estado' => 'cancelada',
            ],
            [
                'user_id' => 1,
                'maquina_id' => 2,
                'fecha_inicio' => '2025-06-20',
                'fecha_fin' => '2025-06-20',
                'monto_total' => 400.00,
                'fecha_reserva' => '2025-06-20 16:20:00',
                'estado' => 'completada',
            ],

            // 3 RESERVAS EN 2025-07-05 (segundo pico)
            [
                'user_id' => 2,
                'maquina_id' => 1,
                'fecha_inicio' => '2025-07-05',
                'fecha_fin' => '2025-07-07',
                'monto_total' => 1950.00,
                'fecha_reserva' => '2025-07-05 08:10:00',
                'estado' => 'completada',
            ],
            [
                'user_id' => 3,
                'maquina_id' => 2,
                'fecha_inicio' => '2025-07-05',
                'fecha_fin' => '2025-07-06',
                'monto_total' => 600.00,
                'fecha_reserva' => '2025-07-05 13:30:00',
                'estado' => 'cancelada',
            ],
            [
                'user_id' => 1,
                'maquina_id' => 3,
                'fecha_inicio' => '2025-07-05',
                'fecha_fin' => '2025-07-08',
                'monto_total' => 850.00,
                'fecha_reserva' => '2025-07-05 10:45:00',
                'estado' => 'completada',
            ],

            // 3 RESERVAS EN 2025-07-10 (tercer pico)
            [
                'user_id' => 2,
                'maquina_id' => 1,
                'fecha_inicio' => '2025-07-10',
                'fecha_fin' => '2025-07-11',
                'monto_total' => 780.00,
                'fecha_reserva' => '2025-07-10 15:20:00',
                'estado' => 'completada',
            ],
            [
                'user_id' => 3,
                'maquina_id' => 2,
                'fecha_inicio' => '2025-07-10',
                'fecha_fin' => '2025-07-12',
                'monto_total' => 450.00,
                'fecha_reserva' => '2025-07-10 09:15:00',
                'estado' => 'confirmada',
            ],
            [
                'user_id' => 1,
                'maquina_id' => 3,
                'fecha_inicio' => '2025-07-10',
                'fecha_fin' => '2025-07-10',
                'monto_total' => 650.00,
                'fecha_reserva' => '2025-07-10 12:00:00',
                'estado' => 'cancelada',
            ],
        ]);
    }
}
