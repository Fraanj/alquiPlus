<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maquinaria extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_id',
        'disponibilidad_id',
        'precio_por_dia',
        'imagen',
        'politica_reembolso',
        'disclaimer',
        'anio_produccion',
        'sucursal'
    ];

    // Constantes para las sucursales disponibles
    public const SUCURSALES = [
        'La Plata',
        'Berisso',
        'Ensenada'
    ];

    // lo agregue para que me devuelva el tipo de maquinaria en el show
    public function tipo()
    {
        return $this->belongsTo(TiposMaquinaria::class, 'tipo_id');
    }

    // Método helper para obtener las sucursales disponibles
    public static function getSucursales()
    {
        return self::SUCURSALES;
    }
}
