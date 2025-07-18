<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Importar Str

class MaquinariaSeeder extends Seeder
{
    public function run()
    {
        $tipos = ['Excavadora', 'Grúa', 'Retroexcavadora', 'Compactadora', 'Camión Volcador'];
        $sucursales = ['La Plata', 'Berisso', 'Ensenada'];

        for ($i = 1; $i <= 1; $i++) {
            // Generar un código simple y único para el seeder
            $codigo = strtoupper(Str::random(3)) . sprintf('%03d', $i); // Ejemplo: ABC001, XYZ002

            DB::table('maquinarias')->insert([
                'codigo' => $codigo, // Añadido el código
                'nombre' => "Maquinaria $i",
                'descripcion' => "Descripción de maquinaria $i",
                'tipo_id' => rand(1, 3),
                'disponibilidad_id' => 1,
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
        for ($i = 2; $i <= 2; $i++) {
            // Generar un código simple y único para el seeder
            $codigo = strtoupper(Str::random(3)) . sprintf('%03d', $i); // Ejemplo: ABC001, XYZ002

            DB::table('maquinarias')->insert([
                'codigo' => $codigo, // Añadido el código
                'nombre' => "Maquinaria $i",
                'descripcion' => "Descripción de maquinaria $i",
                'tipo_id' => rand(1, 3),
                'disponibilidad_id' => 1,
                'precio_por_dia' => rand(10000, 20000),
                'imagen' => "imagen$i.jpg",
                'politica_reembolso' => collect(['0', '20', '100'])->random(),
                'disclaimer' => rand(0, 1) ? 'Sujeto a condiciones' : null,
                'anio_produccion' => rand(2015, 2023),
                'sucursal' => $sucursales[array_rand($sucursales)],
                'entregada' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        for ($i = 3; $i <= 10; $i++) {
            // Generar un código simple y único para el seeder
            $codigo = strtoupper(Str::random(3)) . sprintf('%03d', $i); // Ejemplo: ABC001, XYZ002

            DB::table('maquinarias')->insert([
                'codigo' => $codigo, // Añadido el código
                'nombre' => "Maquinaria $i",
                'descripcion' => "Descripción de maquinaria $i",
                'tipo_id' => rand(1, 3),
                'disponibilidad_id' => 1,
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
