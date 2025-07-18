<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Maquinaria;
use Carbon\Carbon;

class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    public function definition(): array
    {
        $fechaInicio = $this->faker->dateTimeBetween('2025-06-01', '2025-07-04');
        $fechaFin = (clone $fechaInicio)->modify('+' . $this->faker->numberBetween(1, 7) . ' days');

        return [
            'user_id' => 4, // Por defecto user_id = 5
            'maquina_id' => $this->faker->numberBetween(1, 10), // Asumiendo que tienes 3 maquinarias
            'fecha_inicio' => $fechaInicio->format('Y-m-d'),
            'fecha_fin' => $fechaFin->format('Y-m-d'),
            'monto_total' => $this->faker->randomFloat(2, 400, 3000),
            'fecha_reserva' => $fechaInicio->format('Y-m-d H:i:s'),
            'estado' => 'completada',
        ];
    }


}
