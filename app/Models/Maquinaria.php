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
        'anio_produccion'
    ];

    public function tipo()
{
    return $this->belongsTo(TiposMaquinaria::class, 'tipo_id');
}
}
