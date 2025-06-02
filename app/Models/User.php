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
        'nombre',
        'email',
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
     * Mapeo de campos para Laravel Auth
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Casts de tipos
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'edad' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Constantes de timestamps personalizadas
     */
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Métodos helper para rolees (usando ENUM)
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

    public function hasrolee(string $rolee): bool
    {
        return $this->role === $rolee;
    }

    public function canManageMachinery(): bool
    {
        return in_array($this->role, ['admin', 'employee']);
    }

    /**
     * Accessor para name (por compatibilidad con Breeze)
     */
    public function getNameAttribute()
    {
        return $this->nombre;
    }

    /**
     * Accessor para password (por compatibilidad con Breeze)
     */
    public function getPasswordAttribute()
    {
        return $this->password;
    }

    /**
     * Mutator para name (por compatibilidad con Breeze)
     */
    public function setNameAttribute($value)
    {
        $this->attributes['nombre'] = $value;
    }

    /**
     * Mutator para password (por compatibilidad con Breeze)
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value;
    }
}
