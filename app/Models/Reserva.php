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
        return ($this->estado == "pendiente") and ($this->fecha_inicio > \Carbon\Carbon::today() && $this->fecha_fin >= \Carbon\Carbon::today());
    }
    public function getPoliticaReembolso()
    {
        return $this->maquinaria->politica_reembolso;
    }
    public function cancelar()
    {
        $this->estado = "cancelada";
        $this->save();
    }
    public function completar()
    {
        $this->maquinaria->estado = "completada";
        $this->save();
    }
    //agrego logica para evitar repetir codigo a la hora de mostrar los estados
    private function getEstadoBadge()
    {
        $badges = [
            'pendiente' => [
                'class' => 'estado-pendiente',
                'icon' => '⏳',
                'text' => 'Pendiente'
            ],
            'confirmada' => [
                'class' => 'estado-confirmada', 
                'icon' => '✅',
                'text' => 'Confirmada'
            ],
            'cancelada' => [
                'class' => 'estado-cancelada',
                'icon' => '❌', 
                'text' => 'Cancelada'
            ],
            'completada' => [
                'class' => 'estado-completada',
                'icon' => '🎉',
                'text' => 'Completada'
            ]
        ];

        return $badges[$this->estado] ?? [
            'class' => 'estado-default',
            'icon' => '❓',
            'text' => $this->estado
        ];
    }
    public function getEstado()
    {
        $badge = $this->getEstadoBadge();
        return "<span class=\"estado-badge {$badge['class']}\">{$badge['icon']} {$badge['text']}</span>";
    }
}