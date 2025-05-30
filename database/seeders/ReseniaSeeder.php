<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReseniaSeeder extends Seeder
{
    public function run(): void
    {
        // Asegúrate de que existan usuarios y maquinarias antes de correr este seeder
        DB::table('resenias')->insert([
            [
                'user_id' => 1,
                'maquina_id' => 1,
                'comentario' => 'Excelente máquina, muy eficiente.',
                'calificacion' => 5,
                'fecha' => now(),
            ],
            [
                'user_id' => 1,
                'maquina_id' => 3,
                'comentario' => 'Funciona bien pero podría ser más silenciosa.',
                'calificacion' => 4,
                'fecha' => now(),
            ],
            [
                'user_id' => 1,
                'maquina_id' => 2,
                'comentario' => null,
                'calificacion' => 3,
                'fecha' => now(),
            ],
        ]);
    }
}
