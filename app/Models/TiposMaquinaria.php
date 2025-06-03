<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposMaquinaria extends Model
{
    protected $table = 'tipos_maquinaria'; // acá el nombre real de la tabla
    protected $fillable = ['nombre'];
}