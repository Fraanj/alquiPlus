<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maquinaria extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo', // Añadido el nuevo campo
        'nombre',
        'descripcion',
        'tipo_id',
        'disponibilidad_id',
        'precio_por_dia',
        'imagen',
        'politica_reembolso',
        'disclaimer',
        'anio_produccion',
        'sucursal',
        'entregada'
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

    public function tieneReservasPendientes()
    {
        return $reservas = \App\Models\Reserva::where('maquina_id', $this->id)
            ->where('fecha_fin', '>=', \Carbon\Carbon::yesterday())
                ->exists();
    }
    public function entregada()
    {
        $this->entregada = true;
        $this->save();
    }
    public function recibida()
    {
        $this->entregada = false;
        $this->save();
    }
}
