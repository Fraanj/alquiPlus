<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'name',
        'email',
        'dni',
        'edad',
        'password',
        'telefono',
        'role',
    ];

    /**
     * Campos ocultos en serialización
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts de tipos
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'edad' => 'integer',
        ];
    }

    /**
     * Métodos helper para roles
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function hasRole(string $role): bool          //  Corregido typo
    {
        return $this->role === $role;
    }

    public function canManageMachinery(): bool
    {
        return in_array($this->role, ['admin', 'employee']);
    }

    /**
     * Formatear DNI para mostrar
     */
    public function getFormattedDniAttribute(): string
    {
        if (strlen($this->dni) === 8) {
            return number_format($this->dni, 0, '', '.');
        }
        return $this->dni;
    }
}
