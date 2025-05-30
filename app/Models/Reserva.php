<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'usuario_id',
        'maquina_id',
        'fecha_inicio',
        'fecha_fin',
        'monto_total',
        'fecha_reserva',
    ];

    public $timestamps = false;

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function maquinaria()
    {
        return $this->belongsTo(Maquinaria::class, 'maquina_id');
    }
}
