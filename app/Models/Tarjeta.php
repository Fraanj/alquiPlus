<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'nombre_titular',
        'codigo_seguridad',
        'saldo'
    ];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    /**
     * Obtener el saldo actual
     */
    public function getSaldo(): float
    {
        return (float) $this->saldo;
    }

    /**
     * Verificar si tiene saldo suficiente
     */
    public function tieneSaldoSuficiente(float $monto): bool
    {
        return $this->saldo >= $monto;
    }

    /**
     * Debitar saldo (restar dinero)
     */
    public function debitar(float $monto): bool
    {
        if (!$this->tieneSaldoSuficiente($monto)) {
            return false;
        }

        $this->saldo -= $monto;
        $this->save();
        return true;
    }

    /**
     * Acreditar saldo (sumar dinero)
     */
    public function acreditar(float $monto): bool
    {
        $this->saldo += $monto;
        $this->save();
        return true;
    }

    /**
     * Formatear saldo para mostrar
     */
    public function getSaldoFormateadoAttribute(): string
    {
        return '$' . number_format($this->saldo, 2, ',', '.');
    }
}
