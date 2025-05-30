<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resenia extends Model
{
    use HasFactory;

    protected $table = 'resenias';

    protected $fillable = [
        'user_id',
        'maquina_id',
        'comentario',
        'calificacion',
        'fecha',
    ];

    public $timestamps = false; // Usamos el campo 'fecha' como timestamp personalizado

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con la máquina
    public function maquinaria()
    {
        return $this->belongsTo(Maquinaria::class, 'maquina_id');
    }
}
