<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Reserva;
use Database\Factories\ReservaFactory;

class ReservaSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar tabla
        DB::table('reservas')->truncate();

        // SOLO 3 RESERVAS PARA MARIA (user_id = 3) - Casos límite
        DB::table('reservas')->insert([
            [
                'user_id' => 4,
                'maquina_id' => 2,
                'fecha_inicio' => '2025-07-07',
                'fecha_fin' => '2025-07-14',
                'monto_total' => 2100.00,
                'fecha_reserva' => '2025-07-07 00:00:00',
                'estado' => 'confirmada', // Ya pasó
            ],
            [
                'user_id' => 4,
                'maquina_id' => 1,
                'fecha_inicio' => '2025-07-15',
                'fecha_fin' => '2025-07-19',
                'monto_total' => 1200.00,
                'fecha_reserva' => '2025-07-15 00:00:00',
                'estado' => 'completada', // En curso (hoy es 18 jul)
            ],
            [
                'user_id' => 4,
                'maquina_id' => 3,
                'fecha_inicio' => '2025-07-20',
                'fecha_fin' => '2025-07-23',
                'monto_total' => 950.00,
                'fecha_reserva' => '2025-07-20 00:00:00',
                'estado' => 'pendiente', // Futura
            ],
        ]);

        // GENERAR 60 RESERVAS CON FACTORY para user_id = 5 (1 jun - 4 jul)
        Reserva::factory()
            ->count(2)
            ->create();

        // Opcional: Crear algunas reservas agrupadas en días específicos para mejores gráficos
        $diasPico = ['2025-06-15', '2025-06-20'];

        foreach ($diasPico as $dia) {
            Reserva::factory()
                ->count(3)
                ->create([
                    'fecha_inicio' => $dia,
                    'fecha_reserva' => $dia . ' 09:00:00',
                    'user_id' => 4,
                ]);
        }
    }
}
