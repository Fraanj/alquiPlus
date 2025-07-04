<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon; // Importar Carbon para el cálculo de la edad

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
        'fecha_nacimiento', // Cambiado de 'edad'
        'password',
        'telefono',
        'role',
        'is_active',
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
            'fecha_nacimiento' => 'date', // Cambiado de 'edad' y tipo a 'date'
            'is_active' => 'boolean',
        ];
    }

    /**
     * Accesor para calcular la edad dinámicamente.
     * El nombre del método debe ser get<NombreAtributo>Attribute.
     * Laravel lo llamará automáticamente cuando intentes acceder a $user->edad.
     */
    public function getEdadAttribute(): ?int
    {
        if ($this->fecha_nacimiento) {
            return Carbon::parse($this->fecha_nacimiento)->age;
        }
        return null;
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

    public function hasRole(string $role): bool
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

    public function scopeEmployees($query)  //retorna empleados
    {
        return $query->where('role', 'employee');
    }

    // Métodos para activar/desactivar empleados
    public function deactivate(): bool
    {
        $this->is_active = false;
        return $this->save();
    }

    public function activate(): bool
    {
        $this->is_active = true;
        return $this->save();
    }

    public function isActive(): bool
    {
        return $this->is_active ?? true; // Por defecto activo si no está definido
    }

    // Scope para empleados activos
    public function scopeActiveEmployees($query)
    {
        return $query->where('role', 'employee')->where('is_active', true);
    }

    // Scope para empleados inactivos
    public function scopeInactiveEmployees($query)
    {
        return $query->where('role', 'employee')->where('is_active', false);
    }
}
