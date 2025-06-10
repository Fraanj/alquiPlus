<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon; // Importar Carbon

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generar una fecha de nacimiento para alguien entre 18 y 80 años
        $birthDate = Carbon::now()->subYears(fake()->numberBetween(18, 80))->subDays(fake()->numberBetween(0, 365));

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'dni' => fake()->unique()->numerify('########'), // DNI único de 8 dígitos
            // 'edad' => fake()->numberBetween(18, 80), // Campo original eliminado
            'fecha_nacimiento' => $birthDate->format('Y-m-d'), // Nuevo campo
            'telefono' => fake()->phoneNumber(),
            'role' => 'user',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should be an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Indicate that the user should be an employee.
     */
    public function employee(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'employee',
        ]);
    }
}
