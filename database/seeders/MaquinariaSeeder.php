<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaquinariaSeeder extends Seeder
{
    public function run()
    {
        $tipos = ['Excavadora', 'Grúa', 'Retroexcavadora', 'Compactadora', 'Camión Volcador'];
        $sucursales = ['La Plata', 'Berisso', 'Ensenada'];

        for ($i = 1; $i <= 10; $i++) {
            DB::table('maquinarias')->insert([
                'nombre' => "Maquinaria $i",
                'descripcion' => "Descripción de maquinaria $i",
                'tipo_id' => rand(1, 3), // asumiendo que hay 3 tipos
                'disponibilidad_id' => rand(1, 2), // asumiendo que hay 2
                'precio_por_dia' => rand(10000, 20000),
                'imagen' => "imagen$i.jpg",
                'politica_reembolso' => collect(['0', '20', '100'])->random(),
                'disclaimer' => rand(0, 1) ? 'Sujeto a condiciones' : null,
                'anio_produccion' => rand(2015, 2023),
                'sucursal' => $sucursales[array_rand($sucursales)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
