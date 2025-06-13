<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon; // 1. Importar Carbon

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'dni' => [
                'required',
                'string',
                'regex:/^[0-9]{7,8}$/',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'fecha_nacimiento' => [ // 3. Añadida validación para fecha_nacimiento
                'required',
                'date_format:Y-m-d', // Asegura el formato que envía Flatpickr
                'before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'), // Debe tener al menos 18 años
                'after_or_equal:' . Carbon::now()->subYears(100)->format('Y-m-d')  // No más de 100 años (opcional, pero buena práctica)
            ],
            'telefono' => ['nullable', 'string', 'max:20'],
            'current_password' => ['required', 'current_password'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 100 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.regex' => 'El DNI debe contener entre 7 y 8 dígitos.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.', // 5. Añadidos mensajes para fecha_nacimiento
            'fecha_nacimiento.date_format' => 'La fecha de nacimiento no tiene un formato válido (YYYY-MM-DD).',
            'fecha_nacimiento.before_or_equal' => 'Debes tener al menos 18 años para registrarte.',
            'fecha_nacimiento.after_or_equal' => 'La fecha de nacimiento indica una edad no válida (mayor a 100 años).',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'current_password.required' => 'La contraseña es obligatoria.',
            'current_password.current_password' => 'La contraseña ingresada no es correcta.',
        ];
    }
}
