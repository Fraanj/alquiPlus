<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tarjeta;

class TarjetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tarjetas = [
            [
                'numero' => '4111111111111111',
                'nombre_titular' => 'JUAN PEREZ',
                'codigo_seguridad' => '123',
                'saldo' => 1500000.50,
            ],
            [
                'numero' => '5555555555554444',
                'nombre_titular' => 'MARIA GONZALEZ',
                'codigo_seguridad' => '456',
                'saldo' => 8500.00,
            ],
            [
                'numero' => '4000000000000002',
                'nombre_titular' => 'CARLOS RODRIGUEZ',
                'codigo_seguridad' => '789',
                'saldo' => 227500.25,
            ],
            [
                'numero' => '378282246310005',
                'nombre_titular' => 'ANA MARTINEZ',
                'codigo_seguridad' => '321',
                'saldo' => 500.00,
            ],
            [
                'numero' => '6011111111111117',
                'nombre_titular' => 'LUIS FERNANDEZ',
                'codigo_seguridad' => '654',
                'saldo' => 0.00,
            ],
            [
                'numero' => '4242424242424242',
                'nombre_titular' => 'SOFIA TORRES',
                'codigo_seguridad' => '987',
                'saldo' => 12000.00,
            ],
            [
                'numero' => '5105105105105100',
                'nombre_titular' => 'DIEGO MORALES',
                'codigo_seguridad' => '234',
                'saldo' => 35000.75,
            ]
        ];

        foreach ($tarjetas as $tarjeta) {
            Tarjeta::create($tarjeta);
        }

        $this->command->info('Se crearon ' . count($tarjetas) . ' tarjetas.');
    }
}
