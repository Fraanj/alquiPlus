<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Maquinaria;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'user_id',
        'maquina_id',
        'fecha_inicio',
        'fecha_fin',
        'monto_total',
        'estado',
        'fecha_reserva',
    ];

    public $timestamps = false;

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function maquinaria()
    {
        return $this->belongsTo(Maquinaria::class, 'maquina_id')->withTrashed();
    }
    public function activa()
    {
        return $this->fecha_inicio > \Carbon\Carbon::today() && $this->fecha_fin >= \Carbon\Carbon::today();
    }
    public function getPoliticaReembolso()
    {
        return $this->maquinaria->politica_reembolso;
    }
}